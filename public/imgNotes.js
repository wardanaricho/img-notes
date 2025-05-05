class ImageNotes {
    constructor(imageSelector, containerSelector) {
        this.$image = $(imageSelector);
        this.$container = $(containerSelector);
        this.counter = 1;
        this.points = [];

        this.initStyle();
        this.initModal();
        this.initEvents();
    }

    initStyle() {
        const style = `
            <style>
                .marker {
                    position: absolute;
                    width: 24px;
                    height: 24px;
                    background-color: black;
                    border: 1px solid white;
                    color: white;
                    border-radius: 50%;
                    text-align: center;
                    line-height: 24px;
                    font-size: 14px;
                    cursor: pointer;
                    transform: translate(-50%, -50%);
                    z-index: 10;
                }
            </style>
        `;
        $("head").append(style);
    }

    initModal() {
        const modalHtml = `
            <div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="noteForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Note <span id="note-number"></span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="note-x">
                                <input type="hidden" id="note-y">
                                <input type="hidden" name="snapshot" id="snapshot">
                                <textarea id="note-text" class="form-control" placeholder="Enter your note" required autofocus></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-danger" id="delete-note">Hapus</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        `;
        $("body").append(modalHtml);
        this.modal = new bootstrap.Modal(document.getElementById("noteModal"));

        $("#noteModal").on("shown.bs.modal", function () {
            $("#note-text").trigger("focus");
        });
    }

    initEvents() {
        this.$image.on("click", (e) => {
            const rect = this.$image[0].getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            $("#note-x").val(x);
            $("#note-y").val(y);
            $("#note-number").text(this.counter);
            $("#note-text").val("");

            this.editing = false;
            this.modal.show();
        });

        $("#noteForm").on("submit", (e) => {
            e.preventDefault();
            const note = $("#note-text").val();
            const x = parseFloat($("#note-x").val());
            const y = parseFloat($("#note-y").val());
            const number = parseInt($("#note-number").text());

            if (this.editing) {
                const index = this.points.findIndex((p) => p.number === number);
                if (index !== -1) {
                    this.points[index].note = note;
                    $(".marker").each(function () {
                        if (parseInt($(this).text()) === number) {
                            const tooltip = bootstrap.Tooltip.getInstance(this);
                            if (tooltip) tooltip.dispose();
                            $(this)
                                .attr("title", note)
                                .attr("data-bs-original-title", note);
                            new bootstrap.Tooltip(this);
                        }
                    });
                }
            } else {
                this.createMarker(x, y, this.counter, note);
                this.points.push({ x, y, number: this.counter, note });
                this.counter++;
            }

            this.editing = false;
            this.editNumber = null;
            this.modal.hide();
        });

        $("#delete-note").on("click", () => {
            if (!this.editNumber) return;

            this.points = this.points.filter(
                (p) => p.number !== this.editNumber
            );
            $(".marker").each((_, el) => {
                if (parseInt($(el).text()) === this.editNumber) {
                    const tooltip = bootstrap.Tooltip.getInstance(el);
                    if (tooltip) tooltip.dispose();
                    $(el).remove();
                }
            });

            this.modal.hide();
        });
    }

    createMarker(x, y, number, note) {
        const $div = $("<div></div>", {
            class: "marker",
            text: number,
            title: note,
            "data-bs-toggle": "tooltip",
            css: {
                left: `${x}px`,
                top: `${y}px`,
            },
        });

        $div.on("click", (e) => {
            e.stopPropagation();
            const point = this.points.find((p) => p.number === number);
            if (point) {
                $("#note-x").val(point.x);
                $("#note-y").val(point.y);
                $("#note-number").text(point.number);
                $("#note-text").val(point.note);

                this.editing = true;
                this.editNumber = point.number;
                this.modal.show();
            }
        });

        this.$container.append($div);
        new bootstrap.Tooltip($div[0]);
    }

    attachToForm(formSelector) {
        const form = $(formSelector);

        form.on("submit", async (e) => {
            e.preventDefault();

            const markers = this.getMarkers();
            const json = JSON.stringify(markers);
            let inputMarkers = form.find('input[name="markers"]');
            if (inputMarkers.length === 0) {
                inputMarkers = $("<input>")
                    .attr({ type: "hidden", name: "markers" })
                    .appendTo(form);
            }
            inputMarkers.val(json);

            const canvas = await html2canvas(this.$container[0]);

            const dataURL = canvas.toDataURL("image/jpeg", 0.9);

            let inputSnapshot = form.find('input[name="snapshot"]');
            if (inputSnapshot.length === 0) {
                inputSnapshot = $("<input>")
                    .attr({ type: "hidden", name: "snapshot" })
                    .appendTo(form);
            }
            inputSnapshot.val(dataURL);

            form.off("submit").submit();
        });
    }

    loadMarkers(markers) {
        markers.forEach((marker) => {
            this.createMarker(marker.x, marker.y, marker.number, marker.note);
            this.points.push(marker);
            this.counter = Math.max(this.counter, marker.number + 1);
        });
    }

    getMarkers() {
        return this.points;
    }
}
