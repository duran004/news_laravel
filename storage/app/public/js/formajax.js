var jquery_load = 0;
class Formajax {
    div;/* form element */
    title;/* popup title */
    pop;/* popup show true|false */
    refresh;/* after send form refresh page true|false */
    not_back;/* warning confirm true|false */
    refresh_time;/* refresh time */
    not_back_msg = "Bu iÅŸlem geriye alÄ±namaz onaylÄ±yor musunuz?";/* warning message */
    error = "Hata oluÅŸtu!!";/* error message */
    form = null;
    constructor(div = '', title = '', pop = false, refresh = false, not_back = false, refresh_time = 1000) {
        this.div = div;
        this.title = title
        this.pop = pop;
        this.refresh = refresh;
        this.not_back = not_back;
        this.refresh_time = refresh_time;
    }
    init() {
        var t = this;
        t.log(t.div + ' formajax');
        $(document).on('submit', t.div, function (e) {
            e.preventDefault();
            t.form = this;
            if (t.not_back) {
                var promise = new Promise(function (resolve, reject) {
                    $.confirm({
                        title: 'UyarÄ±!',
                        content: t.not_back_msg,
                        buttons: {
                            Evet: {
                                btnClass: 'btn-blue jquery_confirm_btn_blue',
                                action: function () {
                                    t.step(t, t.form);
                                }
                            },
                            Hayir: {
                                btnClass: 'btn-red',
                                action: function () {
                                    $.alert('Ä°ÅŸlem iptal edildi!');
                                }
                            }
                        },
                        onContentReady: function () {
                            console.log(this.buttons.Evet);
                            var self = this;
                            this.buttons.Evet.disable();
                            var i = 3;
                            var interval = setInterval(function () {
                                self.buttons.Evet.setText('Evet (' + i + ')');
                                if (i == 0) {
                                    clearInterval(interval);
                                    self.buttons.Evet.enable();
                                    self.buttons.Evet.setText('Evet');
                                }
                                i--;
                            }, 1000);

                        }

                    });
                });
            } else {
                t.step(t, t.form);
            }

        });
    }
    step(t, thisform) {
        var form = $(thisform);
        var buttons = form.find('.btn');
        $(buttons[buttons.length - 1]).attr('disabled', 'false');
        $(buttons[buttons.length - 1]).append('<div class="spinner-grow" role="status"><span class="visually-hidden">Loading...</span></div>');
        var formData2 = new FormData(thisform);
        var all = $(thisform).find("input[type=checkbox]"); console.log(all);
        for (var i = 0; i < all.length; i++) {
            if (typeof $(all[i]).attr('name') !== 'undefined' && $(all[i]).attr('name') !== false) {
                formData2.append($(all[i]).attr('name'), $(all[i]).prop('checked'));
            }
        }
        if (form.attr('method').toLowerCase() == 'get') {/*if method is get add url*/
            var get_url = "";
            var all = $(thisform).find("input"); console.log(all);
            for (var i = 0; i < all.length; i++) {
                if (typeof $(all[i]).attr('name') !== 'undefined' && $(all[i]).attr('name') !== false) {
                    get_url += $(all[i]).attr('name') + '=' + $(all[i]).val() + '&';
                }
            }
            all = $(thisform).find("input[type=checkbox]"); console.log(all);
            for (var i = 0; i < all.length; i++) {
                if (typeof $(all[i]).attr('name') !== 'undefined' && $(all[i]).attr('name') !== false) {
                    if (typeof $(all[i]).attr('name') !== 'undefined' && $(all[i]).attr('name') !== false) { get_url += '&' + $(all[i]).attr('name') + '=' + $(all[i]).prop('checked'); }
                }
            }
            all = $(thisform).find("select"); console.log(all);
            for (var i = 0; i < all.length; i++) {
                if (typeof $(all[i]).attr('name') !== 'undefined' && $(all[i]).attr('name') !== false) { get_url += '&' + $(all[i]).attr('name') + '=' + $(all[i]).val(); }
            }
            all = $(thisform).find("textarea"); console.log(all);
            for (var i = 0; i < all.length; i++) {
                if (typeof $(all[i]).attr('name') !== 'undefined' && $(all[i]).attr('name') !== false) { get_url += '&' + $(all[i]).attr('name') + '=' + $(all[i]).val(); }
            }
            formData2 = get_url;
        }
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData2,
            processData: false,
            contentType: false,
            success: function (data) {
                try {
                    data = JSON.parse(data);
                    if (t.pop) {
                        t.popup(data[1], t.title, t.div.replace('.', '').replace('#', '') + '_popup');
                    }
                    if (t.refresh && data[0]) {
                        window.setTimeout(function () { location.reload(); }, t.refresh_time);
                    }
                } catch (e) {
                    if (t.pop) {
                        t.popup(data, t.title, t.div.replace('.', '').replace('#', '') + '_popup');
                    }
                    if (t.refresh) {
                        window.setTimeout(function () { location.reload(); }, t.refresh_time);
                    }
                }
                $(buttons[buttons.length - 1]).removeAttr('disabled');
                $(buttons[buttons.length - 1]).find('.spinner-grow').remove();
            }
        }).fail(function (xhr, status, error) {
            t.popup(error, t.error);
            $(buttons[buttons.length - 1]).removeAttr('disabled');
            $(buttons[buttons.length - 1]).find('.spinner-grow').remove();
        });
    }
    popup(html, title, pop_class = '', max_height = "500px", max_width = "500px") {
        max_width = "max-width:" + max_width + ";";
        max_height = "max-height:" + max_height + ";";
        $('body').css('overflow-y', 'hidden');
        $('body').append('<div class="modal pt-5 ' + pop_class + '" style="backdrop-filter: blur(4px);background: rgba(0,0,0,30%);z-index:10;display:block;" tabindex="-1" role="dialog">'
            + '<div class="modal-dialog" style="' + max_width + max_height + '" role="document">'
            + '<div class="modal-content">'
            + '<div class="modal-header">'
            + '<h5 class="modal-title">' + title + '</h5>'
            + '<button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">'
            + '<span aria-hidden="true">&times;</span>'
            + '</button>'
            + '</div>'
            + '<div class="modal-body">'
            + html
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>'); $('.modal').show();
        $('html').css('overflow-y', 'hidden');


    }
    close() {
        $(document).on('click', '.modal .close', function () {
            $(this).closest('.modal').remove();
            $('html').css('overflow-y', 'auto');
        });
    }
    log(str) {
        /*return false; //if do not want to see logs*/
        console.log('%c LOG: ' + str, 'background: #a30000; color: white');
    }
}
function formajax(div, title, pop, refresh, not_back, refresh_time) {
    var fa = new Formajax(div, title, pop, refresh, not_back, refresh_time);
    try {
        var jquery = $();
        //fa.log("this page have jquery");
    } catch (e) {
        if (jquery_load == 0) {
            var s = document.createElement('script');
            s.setAttribute('src', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
            s.setAttribute('integrity', 'sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==');
            s.setAttribute('crossorigin', 'anonymous');
            s.setAttribute('referrerpolicy', 'no-referrer');
            document.body.appendChild(s);
            //fa.log("Jquery loading");
            jquery_load++;
        }
    }
    var int = window.setInterval(function () {
        try {
            var jquery = $();
            clearInterval(int);
            //fa.log("Jquery loaded");
            fa.init();
            fa.close();
        } catch (e) { }
    }, 50);
}

formajax('.formajax', 'Form Ajax', true, true, true, 1000);

new Formajax('.formajax2', 'Form Ajax 2', true, true, true, 1000);