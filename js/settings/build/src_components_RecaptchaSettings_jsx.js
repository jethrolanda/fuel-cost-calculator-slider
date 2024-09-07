"use strict";
(self["webpackChunksettings"] = self["webpackChunksettings"] || []).push([["src_components_RecaptchaSettings_jsx"],{

/***/ "./src/components/RecaptchaSettings.jsx":
/*!**********************************************!*\
  !*** ./src/components/RecaptchaSettings.jsx ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/notification/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/form/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/skeleton/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/divider/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/input/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/button/index.js");
/* harmony import */ var _store_reducer_recaptchaSlice__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../store/reducer/recaptchaSlice */ "./src/store/reducer/recaptchaSlice.js");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");





const RecaptchaSettings = () => {
  const [loading, setLoading] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [api, contextHolder] = antd__WEBPACK_IMPORTED_MODULE_3__["default"].useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description
    });
  };
  const [form] = antd__WEBPACK_IMPORTED_MODULE_4__["default"].useForm();
  const dispatch = (0,react_redux__WEBPACK_IMPORTED_MODULE_2__.useDispatch)();
  let fetched = (0,react_redux__WEBPACK_IMPORTED_MODULE_2__.useSelector)(_store_reducer_recaptchaSlice__WEBPACK_IMPORTED_MODULE_1__.loaded);
  let site_key = (0,react_redux__WEBPACK_IMPORTED_MODULE_2__.useSelector)(_store_reducer_recaptchaSlice__WEBPACK_IMPORTED_MODULE_1__.siteKey);
  let secret_key = (0,react_redux__WEBPACK_IMPORTED_MODULE_2__.useSelector)(_store_reducer_recaptchaSlice__WEBPACK_IMPORTED_MODULE_1__.secretKey);
  const validateMessages = {
    required: '${label} is required!'
  };
  const formSubmit = values => {
    setLoading(true);
    dispatch((0,_store_reducer_recaptchaSlice__WEBPACK_IMPORTED_MODULE_1__.saveRecaptchaValues)({
      values,
      cb: data => {
        setLoading(false);
        if (data.status === 'success') {
          openNotificationWithIcon('success', 'Success', 'Successfully saved.');
        } else {
          openNotificationWithIcon('error', 'Error', data?.message);
        }
      }
    }));
  };
  const errorCheck = () => {
    const fields = form.getFieldsValue();
    if (fields.site_key === "" && fields.secret_key === "") {
      openNotificationWithIcon('error', 'Error', 'Site Key and Secret Key are required.');
    } else if (fields.site_key === "") {
      openNotificationWithIcon('error', 'Error', 'Site Key is required.');
    } else if (fields.secret_key === "") {
      openNotificationWithIcon('error', 'Error', 'Secret Key is required.');
    }
  };
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (fetched === false) dispatch((0,_store_reducer_recaptchaSlice__WEBPACK_IMPORTED_MODULE_1__.fetchRecaptchaValues)());
  }, [fetched]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    form.setFieldsValue({
      site_key,
      secret_key
    });
  }, [site_key, secret_key]);
  return fetched === false ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"], null) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, contextHolder, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_6__["default"], {
    orientation: "left",
    orientationMargin: "0"
  }, "Recaptcha Settings"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Create google recaptcha v2 api key in google and paste the site and secrey key in the form below. Link ", (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    target: "_blank",
    href: "https://developers.google.com/recaptcha/intro"
  }, "here"), "."), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_4__["default"], {
    form: form,
    layout: "vertical",
    style: {
      maxWidth: 600
    },
    validateMessages: validateMessages,
    onFinish: e => formSubmit(e)
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_4__["default"].Item, {
    label: "Site Key",
    name: "site_key",
    rules: [{
      required: true
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_7__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_4__["default"].Item, {
    label: "Secret Key",
    name: "secret_key",
    rules: [{
      required: true
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_7__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_4__["default"].Item, {
    label: " "
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
    type: "primary",
    htmlType: "submit",
    onClick: () => errorCheck(),
    loading: loading
  }, "Save"))));
};
/* harmony default export */ __webpack_exports__["default"] = (RecaptchaSettings);

/***/ })

}]);
//# sourceMappingURL=src_components_RecaptchaSettings_jsx.js.map