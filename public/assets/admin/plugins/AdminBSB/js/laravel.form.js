$.laravel = {};

$.laravel.form = {
    removeError: function (t) {
        var e = t.attr("name"),
            n = this.getErrorLabelClass(e),
            i = n + "_error",
            o = this.findElementParent(t);
        o.removeClass("error"), o.find("#" + i).remove()
    },
    renderError: function (t, e) {
        var n = $(t).attr("name"),
            i = (t.prop("nodeName"), this.findElementParent(t)),
            o = this.getErrorLabelClass(n);
        t.closest(".form-group").length && (i = t.closest(".form-group")), t.addClass(o + "_error_elm"), t.addClass("has-validation-error"), i.append('<label id="' + o + '_error" class="error ' + o + '_error" for="name">' + e + "</label>"), i.addClass("error")
    },
    findElementParent: function (t) {
        var e = t.parent();
        return t.closest(".form-group").length && (e = t.closest(".form-group")), e
    },
    getErrorLabelClass: function (t) {
        return t.replace(/[\[\]]/g, "_").replace(/[._]+$/g, "")
    },
    displayErrors: function (t, e) {
        var n = this;
        $.isPlainObject(t) || (t = JSON.parse(t)), $.each(t, function (t, i) {
            var o = i[0],
                r = t.replace(/\./g, "]["); - 1 !== t.indexOf(".") && (r += "]", r = r.replace("]", ""));
            var s = e.find('[name="' + r + '"]');
            0 == s.length && (s = e.find('[name="' + r + '[]"]')), n.renderError(s, o)
        })
    },
    submit: function (form) {
        _this = this, _form = $(form);
        var _callback = eval(_form.attr("_callback")),
            _reset = _form.attr("reset_form"),
            url = _form.attr("action"),
            data = _form.serializeArray();
        _form.find(".has-validation-error").each(function (t, e) {
            _this.removeError($(e))
        });
        var method = _form.attr("method");
        return this.ajax(_form, url, data, {
            method: method,
            callback: _callback,
            reset: _reset
        }), !1
    },
    ajax: function (t, e, n, i) {
        var o = this,
            r = !(void 0 === i.callback || !$.isFunction(i.callback)) && i.callback,
            s = void 0 !== i.method ? i.method : "GET",
            a = void 0 !== i.reset && i.reset,
            l = void 0 === i.loader || i.loader;
        return l && o.waitMe(t), $.ajax({
            type: s,
            url: e,
            data: n,
            dataType: "json",
            success: function (e, n, i) {
                return l && o.removeWaitMe(t), a && (t.trigger("reset"), t.find("select").selectpicker("refresh")), void 0 !== e.errors && o.displayErrors(e.errors, t), r ? (r(e, t), !1) : ("success" == e.status && void 0 !== e.message ? o.notify(e.message, "success") : "error" == e.status && void 0 !== e.message ? o.notify(e.message, "error") : "info" == e.status && void 0 !== e.message ? o.notify(e.message, "info") : "warning" == e.status && void 0 !== e.message && o.notify(e.message, "warning"), void 0 !== e.target_url && (location.href = e.target_url), !1)
            },
            error: function (e, n, i) {
                return l && o.removeWaitMe(t), 401 == e.status ? (alert("Unauthorized Error. Please refresh page.", "danger"), !1) : 422 == e.status ? (o.displayErrors(e.responseText, t), !1) : void 0
            }
        }), !1
    },
    delete: function (t, e, n) {
        var i = this,
            o = void 0 !== n && void 0 !== n.title ? n.title : "Are you sure?",
            r = void 0 !== n && void 0 !== n.text ? n.text : "Are you sure that you want to delete this?",
            s = void 0 !== n && void 0 !== n.callback ? n.callback : function (e, i) {
                void 0 !== n && void 0 !== n.dataTable ? n.dataTable.ajax.reload() : t.closest("tr").remove(), swal("Deleted!", e.message, "success")
            };
        return swal({
            title: o,
            text: r,
            icon: "warning",
            closeOnEsc: !1,
            closeOnClickOutside: !1,
            dangerMode: !0,
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: !0,
                    className: "",
                    closeModal: !0
                },
                confirm: {
                    text: "Confirm",
                    value: !0,
                    visible: !0,
                    className: "",
                    closeModal: !1
                }
            }
        }).then(function (n) {
            n && i.ajax(t, e, {}, {
                loader: !1,
                method: "DELETE",
                callback: s
            })
        }), !1
    },
    notify: function (t, e) {
        e = void 0 === e ? "success" : e, "function" == typeof $.notify ? $.notify({
            message: t
        }, {
            type: e,
            placement: {
                from: "top",
                align: "right"
            },
            animate: {
                enter: "animated zoomInRight",
                exit: "animated zoomOutRight"
            },
            z_index: 99999999
        }) : alert(t)
    },
    waitMe: function (t) {
        t.waitMe({
            effect: "pulse"
        })
    },
    removeWaitMe: function (t) {
        t.waitMe("hide")
    }
};

$.laravel.dataTables = {

    srNoColumn: function (t, e, n, i) {
        return i.settings._iDisplayStart + (i.row + 1)
    },
    actionColumn: function (t, e, n, i, o) {
        var r = void 0 === n.deleted_at || n.deleted_at ? '<i class="material-icons">delete_forever</i>' : '<i class="material-icons">delete</i>';
        return '<a href="' + window.site.admin_url + "/" + o + "/" + n.id + '/edit"><i class="material-icons">mode_edit</i></a>  <a class="delete_datatable_row" href="' + window.site.admin_url + "/" + o + "/" + n.id + '" data-id="' + n.id + '">' + r + "</a>"
    }
};

$.laravel.datetime = {
    date: null,
    create: function (t) {
        return this.date = new Date(t), this
    },
    toDate: function () {
        return this.date.format("DD/MM/YYYY")
    },
    toTime: function () {
        return this.date.format("HH:mm A")
    },
    toDateTime: function () {
        return this.date.format("DD/MM/YYYY HH:mm A")
    },
    getTimeZone: function () {
        return Intl.DateTimeFormat().resolvedOptions().timeZone
    }
};

String.prototype.replaceAll = function (t, e) {
    return this.replace(new RegExp(t, "g"), e)
};

$(function () {
    $(".laravel_date").each(function () {
        var t = $(this).attr("data-format"),
            e = $(this).attr("data-datetime"),
            n = $.laravel.datetime.create(e);
        "date" == t ? $(this).html(n.toDate()) : "time" == t ? $(this).html(n.toTime()) : $(this).html(n.toDateTime())
    });
});