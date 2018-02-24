System.register("wuethrich44/sso/main", ["flarum/extend", "flarum/app", "flarum/components/HeaderSecondary", "flarum/components/SettingsPage", "flarum/components/LogInModal", "flarum/components/SessionDropdown", "flarum/components/Button"], function (_export) {
    "use strict";

    var extend, override, app, HeaderSecondary, SettingsPage, LogInModal, SessionDropdown, Button;
    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
            override = _flarumExtend.override;
        }, function (_flarumApp) {
            app = _flarumApp["default"];
        }, function (_flarumComponentsHeaderSecondary) {
            HeaderSecondary = _flarumComponentsHeaderSecondary["default"];
        }, function (_flarumComponentsSettingsPage) {
            SettingsPage = _flarumComponentsSettingsPage["default"];
        }, function (_flarumComponentsLogInModal) {
            LogInModal = _flarumComponentsLogInModal["default"];
        }, function (_flarumComponentsSessionDropdown) {
            SessionDropdown = _flarumComponentsSessionDropdown["default"];
        }, function (_flarumComponentsButton) {
            Button = _flarumComponentsButton["default"];
        }],
        execute: function () {

            app.initializers.add('wuethrich44-sso', function () {
                override(LogInModal.prototype, 'init', redirectWhenLoginModalIsOpened);

                extend(HeaderSecondary.prototype, 'items', replaceLoginButton);
                extend(HeaderSecondary.prototype, 'items', replaceSignupButton);

                extend(SettingsPage.prototype, 'accountItems', removeProfileActions);
                extend(SettingsPage.prototype, 'settingsItems', checkRemoveAccountSection);

                extend(SessionDropdown.prototype, 'items', function (items) {
                    if (!items.has('logOut')) {
                        return;
                    }

                    items.replace('logOut', m(
                        "a",
                        { href: "http://neo.8bitmixtape.cc/logout", "class": " hasIcon", type: "button", title: "Log Out" },
                        m("i", { "class": "icon fa fa-sign-out Button-icon" }),
                        m(
                            "span",
                            { "class": "Button-label" },
                            "Log Out"
                        )
                    ));
                });

                function redirectWhenLoginModalIsOpened() {
                    window.location.href = app.forum.data.attributes['wuethrich44-sso.login_url'];
                    throw new Error('Stop execution');
                }

                function replaceLoginButton(items) {
                    if (!items.has('logIn')) {
                        return;
                    }

                    var loginUrl = app.forum.data.attributes['wuethrich44-sso.login_url'];

                    items.replace('logIn', m(
                        "a",
                        { href: loginUrl, className: "Button Button--link" },
                        app.translator.trans('core.forum.header.log_in_link')
                    ));
                }

                function replaceSignupButton(items) {
                    if (!items.has('signUp')) {
                        return;
                    }

                    var signupUrl = app.forum.data.attributes['wuethrich44-sso.signup_url'];

                    items.replace('signUp', m(
                        "a",
                        { href: signupUrl, className: "Button Button--link" },
                        app.translator.trans('core.forum.header.sign_up_link')
                    ));
                }

                function removeProfileActions(items) {
                    items.remove('changeEmail');
                    items.remove('changePassword');
                }

                function checkRemoveAccountSection(items) {
                    if (items.has('account') && items.get('account').props.children.length === 0) {
                        items.remove('account');
                    }
                }
            });
        }
    };
});