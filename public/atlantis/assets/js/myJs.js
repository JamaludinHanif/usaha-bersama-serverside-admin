/**
 *       Helper Function JS
 *
 */

/**
 *       Menyelipkan csrf token pada setup ajax
 *
 */
const ajaxSetup = () => {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
        },
    });
};

/**
 *       Config Toastr
 *
 */
const toastrAlert = () => {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: "slideDown",
        timeOut: 4000,
    };
};

/**
 *       Clear invalid class pada form
 *
 */
const clearInvalid = () => {
    $(".is-invalid").removeClass("is-invalid");
    $(".has-invalid").removeClass("has-invalid");
    $(".invalid-feedback").html("");
};

/**
 *       Format number
 *       @param Int num
 *
 */
const numberFormat = (num) => {
    if ($.isNumeric(num)) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    } else {
        return num;
    }
};

/**
 *       Pengecekan variable kosong atau tidak
 *       @param data
 *
 */
const isEmpty = (data) => {
    if (data == null || data == "" || data == undefined) {
        return true;
    } else {
        return false;
    }
};

/**
 *       Formatting date
 *       @require moment js
 *       @param String date
 *       @param String format
 *       @param String toFormat
 *
 */
const formatDate = (date, format, toFormat) => {
    return moment(date, format).format(toFormat);
};

/**
 *       Huruf depan kapital
 *       @param String text
 *
 */
const ucfirst = (text) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
};

/**
 *       Tombol process
 *       @param jQueryHtmlDomElement element
 *       @param String html (optional)
 *
 */
const processingButton = (element, html = null) => {
    element.attr("disabled", "");
    if (isEmpty(html)) {
        element.html(`<i class="mdi mdi-loading mdi-spin"></i> Memproses..`);
    } else {
        element.html(html);
    }
};

/**
 *       Tombol process selesai
 *       @param jQueryHtmlDomElement element
 *       @param String html (optional)
 *
 */
const processingButtonDone = (element, html = null) => {
    element.removeAttr("disabled");
    if (isEmpty(html)) {
        element.html(`<i class="mdi mdi-check"></i> Simpan`);
    } else {
        element.html(html);
    }
};

/**
 *       Tombol process berlanjut dengan mengganti content html dari button
 *       @param jQueryHtmlDomElement element
 *       @param String html (optional)
 *
 */
const processingButtonContinue = (element, html = null) => {
    if (isEmpty(html)) {
        element.html(
            `<i class="mdi mdi-spin mdi-loading"></i> Sedang mengalihkan..`
        );
    } else {
        element.html(html);
    }
};

/**
 *       Menampilkan invalid response
 *       @param jQueryHtmlDomElement elem
 *       @param Array response
 *
 */
const invalidResponse = (elem, response) => {
    $.each(response, (i, d) => {
        elem.find(`[name="${i}"]`).addClass("is-invalid");
        elem.find(`[name="${i}"]`).siblings(".invalid-feedback").html(d);
        elem.find(`[name="${i}"]`).siblings(".invalid-feedback").show();
        // $(`[name="${i}"]`).siblings('.invalid-feedback').show();
    });
};

/**
 *       Menghapus class warna
 *       @param jQueryHtmlDomElement elem
 *       @param String except
 *
 */
const clearColorText = (elem, except = null) => {
    let classList = ["text-danger", "text-success"];
    $.each(classList, (i, theClass) => {
        if (except != null && theClass != `text-${except}`) {
            elem.removeClass(theClass);
        } else if (except == null) {
            elem.removeClass(theClass);
        }
    });
};

/**
 *       Mengenable tombol
 *       @param jQueryHtmlDomElement elem
 *
 */
const enable = (elem) => {
    elem.removeAttr("disabled");
};

/**
 *       Mendisable tombol
 *       @param jQueryHtmlDomElement elem
 *
 */
const disable = (elem) => {
    elem.attr("disabled", "");
};

/**
 *       Download file dari data base64
 *       @param String filedata  => base64 data
 *       @param String mime      => mime type
 *       @param String filename (opsional)   => Nama file
 *
 */
const downloadFromBase64 = (filedata, mime, filename = null) => {
    let a = document.createElement("a");
    document.body.appendChild(a);
    a.href = `data:${mime};base64,${filedata}`;
    a.style = "display: none";

    if (!isEmpty(filename)) {
        a.download = filename;
    }

    a.click();
    a.remove();
};

/**
 *       Download file dari data base64
 *       @param String filedata  => base64 data
 *       @param String mime      => mime type
 *       @param String filename (opsional)   => Nama file
 *
 */
const copyText = (text) => {
    let input = document.createElement("input");
    document.body.appendChild(input);
    input.value = text;
    input.type = "text";

    input.select();
    input.setSelectionRange(0, 99999); /* For mobile devices */

    document.execCommand("copy");
    input.remove();
};

/**

*/
const or = (value1, value2) => {
    if (!isEmpty(value1)) return value1;

    return value2;
};

const setInvalidFeedback = (inputElement, message) => {
    $(inputElement).addClass("is-invalid");
    $(inputElement)
        .parents(".form-group")
        .find(".invalid-feedback")
        .html(message);
};

const showWithSlide = (elem) => {
    $(elem).slideDown("slow");
};

const hideWithSlide = (elem) => {
    $(elem).slideUp("slow");
};

const showOrHideWithSlide = (elem) => {
    let jElem = $(elem);

    if (jElem.first().is(":hidden")) {
        showWithSlide(elem);
    } else {
        hideWithSlide(elem);
    }
};

const renderLibEvent = () => {
    $(".show-btn").off("click");
    $(".show-btn").on("click", function () {
        let target = $(this).data("target");

        showOrHideWithSlide(target);
    });
};

const notification = (title, message, type, icon) => {
    $.notify(
        {
            icon: icon,
            title: title,
            message: message,
        },
        {
            type: type,
            placement: {
                from: "top",
                align: "right",
            },
            time: 10000,
        }
    );
};

const infoNotification = (title, message) => {
    notification(title, message, "info", "flaticon-alarm-1");
};

const successNotification = (title, message) => {
    notification(title, message, "success", "flaticon-success");
};

const warningNotification = (title, message) => {
    notification(title, message, "warning", "flaticon-error");
};

const errorNotification = (title, message) => {
    notification(title, message, "danger", "flaticon-error");
};

const ajaxErrorHandling = (error, $form = null) => {
    let { status, responseJSON } = error;
    let { message } = responseJSON;

    if (status == 422) {
        if ($form) {
            let { errors } = responseJSON;
            invalidResponse($form, errors);
        }

        if (message == "The given data was invalid.") {
            message = "Harap cek kembali form isian";
        }
    }

    if (status == 419) {
        message = "Harap refresh/reload halaman";
    }

    message = message == "" ? "XHR Invalid" : message;

    warningNotification("Peringatan", message);
};

const ajaxSuccessHandling = (response) => {
    let { message } = response;
    toastrAlert();
    toastr.success(message, "Berhasil");
};

// Tailwind CSS untuk alert
// function alertTailwind(type, title, message, duration = 5000) {
//     const alert = `
//         <div class="bg-${type}-100 w-full border-l-4 border-${type}-500 text-${type}-700 p-2 rounded-md shadow-md" role="alert">
//             <p class="font-bold lg:text-base text-sm">${title}</p>
//             <p class="lg:text-sm text-xs">${message}</p>
//         </div>
//     `;

//     // Tambahkan alert ke container
//     const $alert = $(alert).appendTo('#alert-container');

//     // Hapus alert setelah durasi tertentu
//     setTimeout(() => {
//         $alert.fadeOut(500, function () {
//             $(this).remove();
//         });
//     }, duration);
// }

function alertTailwind(title, message, type = "success", duration = 10000) {
    // Pilihan ikon berdasarkan tipe notifikasi
    const icons = {
        success:
            '<svg class="size-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
        error: '<svg class="size-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 3a9 9 0 1 1-9 9 9 9 0 0 1 9-9Z" /></svg>',
        info: '<svg class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 3a9 9 0 1 1-9 9 9 9 0 0 1 9-9Z" /></svg>',
        warning:
            '<svg class="size-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 3a9 9 0 1 1-9 9 9 9 0 0 1 9-9Z" /></svg>',
    };

    // Container notifikasi
    const container = document.getElementById(
        "notification-container"
    ).firstElementChild;

    // Template notifikasi
    const notification = document.createElement("div");
    notification.className =
        "pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5 transform ease-out duration-300 transition translate-y-2 opacity-0";
    notification.innerHTML = `
        <div class="p-4">
            <div class="flex items-start">
                <div class="shrink-0">
                    ${icons[type]}
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">${title}</p>
                    <p class="mt-1 text-sm text-gray-500">${message}</p>
                </div>
                <div class="ml-4 flex shrink-0">
                    <button type="button" class="close-notification inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Close</span>
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

    // Tambahkan notifikasi ke container
    container.appendChild(notification);

    // Efek muncul
    setTimeout(() => {
        notification.classList.remove("translate-y-2", "opacity-0");
        notification.classList.add("translate-y-0", "opacity-100");
    }, 10);

    // Hapus notifikasi setelah durasi tertentu
    setTimeout(() => closeNotification(notification), duration);

    // Event untuk tombol close
    notification
        .querySelector(".close-notification")
        .addEventListener("click", () => closeNotification(notification));
}

// Fungsi untuk menutup notifikasi
function closeNotification(notification) {
    notification.classList.add("opacity-0");
    setTimeout(() => notification.remove(), 300);
}

const confirmation = (message, yesAction = null, cancelAction = null) => {
    $.confirm({
        title: "Konfirmasi",
        content: message,
        buttons: {
            ya: {
                text: "Ya",
                btnClass: "btn-primary",
                keys: ["enter"],
                action: function () {
                    if (yesAction) {
                        yesAction();
                    }
                },
            },
            batal: {
                text: "Batal",
                btnClass: "btn-danger",
                keys: ["esc"],
                action: function () {
                    if (cancelAction) {
                        cancelAction();
                    }
                },
            },
        },
    });
};

const putValuesToForm = ($form, obj) => {
    Object.keys(obj).map((key) => {
        $form.find(`[name="${key}"]`).val(obj[key]).trigger("change");
    });
};

const previewImageAfterChange = (data) => {
    let {
        fieldSelector,
        previewSelector,
        addedFunction,
        offPreviousEvent,
        defaultSource,
    } = data;

    if (defaultSource) {
        $(previewSelector).attr("src", defaultSource);
        $(previewSelector).show();
    }

    if (offPreviousEvent) {
        $(fieldSelector).off("change");
    }

    $(fieldSelector).on("change", function () {
        let file = $(this).val();

        if (file !== "") {
            let fileType = this.files[0].type;

            if (fileType.substring(0, 5) != "image") {
                alert("File harus berupa foto");
                $(this).val("");

                if (defaultSource) {
                    $(previewSelector).attr("src", defaultSource);
                } else {
                    $(previewSelector).hide();
                }
            } else {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $(previewSelector).attr("src", e.target.result);
                };

                reader.readAsDataURL(this.files[0]);

                $(previewSelector).show();
            }
        } else {
            if (defaultSource) {
                $(previewSelector).attr("src", defaultSource);
            } else {
                $(previewSelector).hide();
            }
        }

        if (addedFunction) {
            addedFunction();
        }
    });
};

const previewImageFromUrl = (inputSelector, previewSelector) => {
    $(inputSelector).on("input", function () {
        const url = $(this).val();
        const preview = $(previewSelector);

        if (url) {
            preview
                .attr("src", url)
                .on("error", function () {
                    $(this).hide();
                })
                .on("load", function () {
                    $(this).show();
                });
        } else {
            preview.hide();
        }
    });
};

function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);
}

/**
 * Preloader
 */
document.addEventListener("DOMContentLoaded", () => {
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }
});

