class FormAjax {
    debug = true;
    dependencies = ['jquery', 'jquery-confirm'];
    elements = 'input, select, textarea, checkbox, radio, button, submit, reset, hidden, password, text, url, email, tel, date, datetime-local, month, week, time, number, range, color';
    constructor(form_element) {
        this.form_element = form_element;
        this.settings = new FormSettings();
        if (this.load_dependencies()) {
            this.init();
        }
    }
    load_dependencies() {
        let is_loaded = true;
        try {
            this.dependencies.forEach(dependency => {
                if (dependency == 'jquery') {
                    if (typeof jQuery == 'undefined') {
                        this.log('jQuery not found', 'error');
                        is_loaded = false;
                    }
                }
                if (dependency == 'jquery-confirm') {
                    if (typeof $.confirm == 'undefined') {
                        this.log('jquery-confirm not found', 'error');
                        is_loaded = false;
                    }
                }
            });
        } catch (e) {
            this.log('Error: ' + e, 'error');
            is_loaded = false;
        }

        return is_loaded;
    }
    init() {
        let _this = this;
        $(document).on('submit', this.form_element, function (e) {
            e.preventDefault();
            this.form = this;
            _this.log('The form has been submitted: ' + _this.form_element);
            _this.handleSubmit(this);
        });
        this.log('form_element:' + this.form_element);
    }
    handleSubmit(form) {
        let _this = this;
        new Promise((resolve, reject) => {
            if (_this.settings.confirm) {
                $.confirm({
                    title: _this.settings.confirm_title,
                    content: _this.settings.confirm_msg,
                    buttons: {
                        Evet: {
                            btnClass: 'btn-blue jquery_confirm_btn_blue',
                            action: function () {
                                _this.submit(form);
                            }
                        },
                        Hayir: {
                            btnClass: 'btn-red',
                            action: function () {
                                $.alert('İşlem iptal edildi!');
                            }
                        }
                    }
                });
            } else {
                _this.submit(form);
            }
        });
    }

    formSettings(FormSettings) {
        this.settings = FormSettings;
    }
    get_elements(form) {
        //[...document.forms[0].elements].forEach(i => { console.log(i) }) 
        return [...form.elements];
    }
    create_url(form) {
        let allElements = $(form).find(this.elements);
        let get_url = allElements.toArray().reduce((url, element) => {
            let $element = $(element);
            let name = $element.attr('name');
            if (name !== undefined && name !== false) {
                let value = $element.is(':checkbox') ? $element.prop('checked') : $element.val();
                this.log('name:' + name + ' value:' + value);
                url += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
            }

            return url;
        }, '');

        return get_url.slice(0, -1); // Son '&' karakterini kaldır
    }

    submit(form) {
        let _this = this;
        let form_data = new FormData(form);
        let form_url = $(form).attr('action');
        let form_method = $(form).attr('method');
        let elements = this.get_elements(form);
        if (form_method.toLowerCase() == 'get') {
            form_data = this.create_url($(form));
        }
        this.log('form_data:' + form_data, 'warning');
        $.ajax({
            url: form_url,
            method: form_method,
            data: form_data,
            processData: false,
            contentType: false,
            success: function (response) {
                if (_this.settings.open_popup) {
                    $.alert({
                        columnClass: 'col-md-12 col-md-offset-3',
                        title: _this.settings.title,
                        content: response,
                        buttons: {
                            Tamam: {
                                btnClass: 'btn-blue jquery_confirm_btn_blue',
                                action: function () {
                                    if (_this.settings.refresh) {
                                        setTimeout(function () {
                                            location.reload();
                                        }, _this.settings.refresh_time);
                                    }
                                }
                            }
                        }
                    });
                } else {
                    if (_this.settings.refresh) {
                        setTimeout(function () {
                            location.reload();
                        }, _this.settings.refresh_time);
                    }
                }
            },
            error: function (response) {
                _this.log('response:' + response, 'error');
            }

        })

    }


    log(str, type = 'info') {
        if (!this.debug) { return; }
        let backgroundColor = '#a30000';
        let color = 'white';
        if (type == 'info') {
            backgroundColor = '#007bff';
            color = 'white';
        } else if (type == 'error') {
            backgroundColor = '#dc3545';
            color = 'white';
        } else if (type == 'warning') {
            backgroundColor = '#ffc107';
            color = 'black';
        } else if (type == 'success') {
            backgroundColor = '#28a745';
            color = 'white';
        }
        console.log('%c' + str, 'background: ' + backgroundColor + '; color: ' + color + '; padding: 5px; border-radius: 5px;');
    }
}

class FormSettings {
    constructor(
        formAjax = null,
        title = 'İşlem Sonucu',
        open_popup = false,
        confirm = false,
        confirm_title = 'Uyarı!',
        confirm_msg = 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
        refresh = false,
        refresh_time = 1000
    ) {
        this.formAjax = formAjax;
        this.title = title
        this.open_popup = open_popup;
        this.refresh = refresh;
        this.refresh_time = refresh_time;
        this.confirm = confirm;
        this.confirm_title = confirm_title;
        this.confirm_msg = confirm_msg;
    }
    set_title(title) {
        this.title = title;
    }

}

//usage
let form = new FormAjax('.formajax');
form.formSettings(new FormSettings(form, 'Form İşlemi2', true, true, 'Uyarı!', 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?', refresh = true, refresh_time = 2000));
// form.settings.set_title('Form İşlemi');