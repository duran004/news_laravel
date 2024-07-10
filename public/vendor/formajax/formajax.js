class FormAjax {
    constructor(formElement) {
        this.debug = true;
        this.dependencies = ['jquery', 'jquery-confirm'];
        this.elementsSelector = 'input, select, textarea, checkbox, radio, button, submit, reset, hidden, password, text, url, email, tel, date, datetime-local, month, week, time, number, range, color';
        this.formElement = formElement;
        this.settings = new FormSettings();
        this.popupSize = 'col-md-12';
        this.laravelPath = '/vendor/formajax/';
        this.loadDependencies().then(() => this.init());
    }
    async loadDependencies() {
        const missingDependencies = this.dependencies.filter(dep => {
            if (dep === 'jquery' && typeof jQuery === 'undefined') {
                return true;
            }
            if (dep === 'jquery-confirm' && (typeof $ === 'undefined' || typeof $.confirm === 'undefined')) {
                return true;
            }
            return false;
        });

        if (missingDependencies.length > 0) {
            for (const dep of missingDependencies) {
                this.log(`${dep} not found`, 'error');
                if (dep === 'jquery') {
                    await this.loadScript(`${this.laravelPath}jquery.js`);
                }
                if (dep === 'jquery-confirm') {
                    await this.loadScript(`${this.laravelPath}jquery-confirm.js`);
                    await this.loadScript(`${this.laravelPath}jquery-confirm.css`);
                }
            }
            return this.loadDependencies();
        }

        return true;
    }

    loadScript(file) {
        return new Promise((resolve, reject) => {
            this.log(`Loading ${file}`);
            const is_js_or_css = file.split('.').pop();
            let element;
            if (is_js_or_css === 'css') {
                element = document.createElement('link');
                element.rel = 'stylesheet';
                element.type = 'text/css';
                element.href = file;
            } else {
                element = document.createElement('script');
                element.src = file;
            }
            element.onload = () => {
                this.log(`${file} loaded successfully`);
                resolve();
            };
            element.onerror = (e) => {
                this.log(e, 'error');
                reject(e);
            };
            document.getElementsByTagName('head')[0].appendChild(element);
        });
    }

    init() {
        $(document).on('submit', this.formElement, (e) => {
            e.preventDefault();
            this.log(`The form has been submitted: ${this.formElement}`);
            this.handleSubmit(e.target);
        });
        this.log(`form_element: ${this.formElement}`);
    }

    handleSubmit(form) {
        this.popupSize = $(form).data('modal-size') || this.popupSize;
        this.log(`popup_size: ${this.popupSize}`);
        if (this.settings.confirm) {
            $.confirm({
                title: this.settings.confirmTitle,
                content: this.settings.confirmMsg,
                buttons: {
                    Evet: {
                        btnClass: 'btn-blue jquery_confirm_btn_blue',
                        action: () => this.submit(form),
                    },
                    Hayir: {
                        btnClass: 'btn-red',
                        action: () => $.alert('İşlem iptal edildi!'),
                    },
                },
            });
        } else {
            this.submit(form);
        }
    }

    setFormSettings(settings) {
        this.settings = settings;
    }

    getElements(form) {
        return [...form.elements];
    }

    createUrl(form) {
        const allElements = $(form).find(this.elementsSelector);
        return allElements.toArray().reduce((url, element) => {
            const $element = $(element);
            const name = $element.attr('name');
            if (name) {
                let value;
                if ($element.is(':checkbox')) {
                    value = $element.prop('checked') ? 'true' : 'false';
                } else {
                    value = $element.val();
                }
                this.log(`name: ${name} value: ${value}`);
                url += `${encodeURIComponent(name)}=${encodeURIComponent(value)}&`;
            }
            return url;
        }, '').slice(0, -1); // Remove the last '&' character
    }
    submit(form) {
        const formData = new FormData();
        const formUrl = $(form).attr('action');
        const formMethod = $(form).attr('method').toLowerCase();
        const allElements = $(form).find(this.elementsSelector);
        const checkboxNames = new Set();

        allElements.each((_, element) => {
            const $element = $(element);
            if ($element.is(':checkbox')) {
                const name = $element.attr('name');
                checkboxNames.add(name);
            } else {
                formData.append($element.attr('name'), $element.val());
            }
        });

        checkboxNames.forEach(name => {
            $(form).find(`input[name="${name}"]:checked`).each((_, el) => {
                formData.append(name, $(el).val()); // Append each checked value
            });
        });

        this.log(`form_data: ${formData}`, 'warning');
        $.ajax({
            url: formUrl,
            method: formMethod,
            data: formData,
            processData: false, // Do not process data
            contentType: false, // Do not set content type
            success: (response, status, xhr) => {
                console.log(response);
                if (xhr.status === 200) {
                    if (response.status) {
                        this.handleSuccess(response);
                    } else {
                        this.handleError(response, 200);
                    }
                } else {
                    this.handleError(xhr);
                }
            },
            error: (xhr) => this.handleError(xhr),
        });
    }

    handleSuccess(response) {
        if (this.settings.openPopup) {
            $.alert({
                columnClass: this.popupSize + ' col-md-offset-3',
                animationSpeed: 0,
                backgroundDismiss: true,
                title: this.settings.title,
                content: response.message,
                closeIcon: true,
                type: 'orange',
                buttons: {
                    Tamam: {
                        isHidden: true,
                        btnClass: 'btn-blue jquery_confirm_btn_blue',
                        action: () => {
                            if (this.settings.refresh) {
                                setTimeout(() => location.reload(), this.settings.refreshTime);
                            }
                        },
                    },
                },
            });
        }
        if (this.settings.refresh) {
            setTimeout(() => location.reload(), this.settings.refreshTime);
        }
    }

    handleError(xhrOrMsg, type = 'error') {
        console.log(xhrOrMsg);
        let errorMessage = '';
        if (type === 200) {
            errorMessage = xhrOrMsg.message;
        } else {
            errorMessage = xhrOrMsg.responseJSON ? xhrOrMsg.responseJSON.message : xhrOrMsg.statusText;
        }


        if (this.settings.openPopup) {
            $.alert({
                columnClass: this.popupSize + ' col-md-offset-3',
                title: 'Error',
                content: errorMessage,
                buttons: {
                    Tamam: {
                        btnClass: 'btn-red',
                    },
                },
            });
        }
    }

    log(message, type = 'info') {
        if (!this.debug) return;

        const logTypes = {
            info: { background: '#007bff', color: 'white' },
            error: { background: '#dc3545', color: 'white' },
            warning: { background: '#ffc107', color: 'black' },
            success: { background: '#28a745', color: 'white' },
        };

        const { background, color } = logTypes[type] || logTypes.info;
        console.log(`%c${message}`, `background: ${background}; color: ${color}; padding: 5px; border-radius: 5px;`);
    }
}

class FormSettings {
    constructor({
        title = 'İşlem Sonucu',
        openPopup = false,
        confirm = false,
        confirmTitle = 'Uyarı!',
        confirmMsg = 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
        refresh = false,
        refreshTime = 1000,
    } = {}) {
        this.title = title;
        this.openPopup = openPopup;
        this.confirm = confirm;
        this.confirmTitle = confirmTitle;
        this.confirmMsg = confirmMsg;
        this.refresh = refresh;
        this.refreshTime = refreshTime;
    }
}

// Usage
const formajax = new FormAjax('.formajax');
formajax.setFormSettings(new FormSettings({}));

const formajax_refresh = new FormAjax('.formajax_refresh');
formajax_refresh.setFormSettings(new FormSettings({ refresh: true }));

const formajax_confirm = new FormAjax('.formajax_confirm');
formajax_confirm.setFormSettings(new FormSettings({ confirm: true, confirmMsg: 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?' }));

const formajax_delete = new FormAjax('.formajax_delete');
formajax_delete.setFormSettings(new FormSettings({ confirm: true, confirmMsg: 'Bu işlem geriye alınamaz onaylıyor musunuz?', refresh: true, refreshTime: 2000, title: 'Silme Sonucu', openPopup: true }));

const formajax_edit = new FormAjax('.formajax_edit');
formajax_edit.setFormSettings(new FormSettings({ openPopup: true, title: 'Düzenleme Sonucu' }));

const formajax_view = new FormAjax('.formajax_view');
formajax_view.setFormSettings(new FormSettings({ openPopup: true, title: 'Görüntüleme Sonucu' }));

const formajax_popup = new FormAjax('.formajax_popup');
formajax_popup.setFormSettings(new FormSettings({ openPopup: true, title: 'Popup Sonucu' }));

const formajax_refresh_popup = new FormAjax('.formajax_refresh_popup');
formajax_refresh_popup.setFormSettings(new FormSettings({ openPopup: true, title: 'Popup Sonucu', refresh: true, refreshTime: 2000 }));