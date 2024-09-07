"use strict";
(self["webpackChunksettings"] = self["webpackChunksettings"] || []).push([["src_components_EmailSettings_jsx"],{

/***/ "./src/components/EmailSettings.jsx":
/*!******************************************!*\
  !*** ./src/components/EmailSettings.jsx ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ EmailSettings; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_quill__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-quill */ "./node_modules/react-quill/lib/index.js");
/* harmony import */ var react_quill__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_quill__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _ant_design_icons__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @ant-design/icons */ "./node_modules/@ant-design/icons/es/icons/MinusCircleOutlined.js");
/* harmony import */ var _ant_design_icons__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @ant-design/icons */ "./node_modules/@ant-design/icons/es/icons/PlusOutlined.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/form/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/notification/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/skeleton/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/divider/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/input/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/space/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/button/index.js");
/* harmony import */ var react_quill_dist_quill_snow_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-quill/dist/quill.snow.css */ "./node_modules/react-quill/dist/quill.snow.css");
/* harmony import */ var _store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../store/reducer/emailSlice */ "./src/store/reducer/emailSlice.js");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");








function EmailSettings() {
  const [saveLoading, setSaveLoading] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [testEmailLoading, setTestEmailLoading] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [form] = antd__WEBPACK_IMPORTED_MODULE_5__["default"].useForm();
  const [api, contextHolder] = antd__WEBPACK_IMPORTED_MODULE_6__["default"].useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description
    });
  };
  const dispatch = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useDispatch)();
  let redirect_url = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useSelector)(_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.modal_redirect_url);
  let email_subject = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useSelector)(_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.subject);
  let email_body = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useSelector)(_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.body);
  let email_cc = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useSelector)(_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.cc);
  let email_bcc = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useSelector)(_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.bcc);
  let fetched = (0,react_redux__WEBPACK_IMPORTED_MODULE_4__.useSelector)(_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.loaded);
  const modules = {
    toolbar: [[{
      header: [1, 2, false]
    }], ["bold", "italic", "underline", "strike", "blockquote"], [{
      list: "ordered"
    }, {
      list: "bullet"
    } /*, {'indent': '-1'}, {'indent': '+1'}*/], ["link"] //'image'
    // ['clean']
    ],

    clipboard: {
      matchVisual: false
    }
  };
  const formats = ["header", "bold", "italic", "underline", "strike", "blockquote", "list", "bullet", "indent", "link", "image"];
  const validateMessages = {
    required: "${label} is required!",
    types: {
      email: "The email is not valid!"
    }
  };
  const errorCheck = () => {
    const fields = form.getFieldsValue();
    const bodyValue = fields.body.replace(/(<([^>]+)>)/gi, "");
    if (fields.subject === "" && bodyValue === "") {
      openNotificationWithIcon("error", "Error", "Subject and Body are required.");
    } else if (fields.subject === "") {
      openNotificationWithIcon("error", "Error", "Subject is required.");
    } else if (bodyValue === "") {
      openNotificationWithIcon("error", "Error", "Body is required.");
    }
  };

  // Save Email Setting
  const formSubmit = values => {
    setSaveLoading(true);
    dispatch((0,_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.saveEmailValues)({
      values,
      cb: data => {
        setSaveLoading(false);
        if (data.status === "success") {
          openNotificationWithIcon("success", "Success", "Successfully saved.");
        } else {
          openNotificationWithIcon("error", "Error", data?.message);
        }
      }
    }));
  };

  // Send Test Email
  const formSendTestEmail = ({
    email
  }) => {
    if (typeof email !== "undefined") {
      setTestEmailLoading(true);
      dispatch((0,_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.sendTestEmail)({
        email,
        cb: data => {
          setTestEmailLoading(false);
          if (data.status === "success") {
            openNotificationWithIcon("success", "Success", "Successfully sent.");
          } else {
            openNotificationWithIcon("error", "Error", data?.message);
          }
        }
      }));
    }
  };
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (fetched === false) dispatch((0,_store_reducer_emailSlice__WEBPACK_IMPORTED_MODULE_3__.fetchEmailValues)());
  }, [fetched]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    form.setFieldsValue({
      modal_redirect_url: redirect_url,
      subject: email_subject,
      body: email_body,
      cc_emails: email_cc,
      bcc_emails: email_bcc
    });
  }, [email_subject, email_body, email_cc]);
  return fetched === false ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_7__["default"], null) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, contextHolder, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"], {
    form: form,
    layout: "vertical",
    validateMessages: validateMessages,
    onFinish: e => formSubmit(e),
    className: "email-settings"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
    orientation: "left",
    orientationMargin: "0"
  }, "Modal Popup"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: "Redirect URL on submit",
    name: "modal_redirect_url",
    tooltip: "If empty, page will refresh after 1 second."
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_9__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
    orientation: "left",
    orientationMargin: "0"
  }, "Email Settings"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: "Subject",
    name: "subject",
    rules: [{
      required: true
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_9__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: "CC"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].List, {
    name: "cc_emails"
  }, (fields, {
    add,
    remove
  }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, fields.map(({
    key,
    name,
    ...restField
  }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_10__["default"], {
    key: key,
    style: {
      display: "flex",
      marginBottom: 8
    },
    align: "baseline"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    ...restField,
    style: {
      flex: "100%"
    },
    name: [name, "cc"],
    rules: [{
      type: "email"
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_9__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_11__["default"], {
    onClick: () => remove(name)
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_12__["default"], {
    type: "dashed",
    onClick: () => add(),
    block: true,
    icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_13__["default"], null)
  }, "Add CC"))))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: "BCC"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].List, {
    name: "bcc_emails"
  }, (fields, {
    add,
    remove
  }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, fields.map(({
    key,
    name,
    ...restField
  }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_10__["default"], {
    key: key,
    style: {
      display: "flex",
      marginBottom: 8
    },
    align: "baseline"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    ...restField,
    style: {
      flex: "100%"
    },
    name: [name, "bcc"],
    rules: [{
      type: "email"
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_9__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_11__["default"], {
    onClick: () => remove(name)
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_12__["default"], {
    type: "dashed",
    onClick: () => add(),
    block: true,
    icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_13__["default"], null)
  }, "Add BCC"))))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: "Body",
    name: "body",
    tooltip: "Tags: {customer_name}, {customer_email}, {estimated_yearly_savings}, {salesperson_name} and {salesperson_position}",
    rules: [{
      required: true
    }, {
      message: "Body is required!",
      validator: (_, value) => {
        if (value.replace(/(<([^>]+)>)/gi, "")) {
          return Promise.resolve();
        } else {
          return Promise.reject("Some message here");
        }
      }
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)((react_quill__WEBPACK_IMPORTED_MODULE_1___default()), {
    theme: "snow",
    modules: modules,
    formats: formats,
    preserveWhitespace: true
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: " "
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_12__["default"], {
    type: "primary",
    htmlType: "submit",
    onClick: () => errorCheck(),
    loading: saveLoading
  }, "Save"))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
    orientation: "left",
    orientationMargin: "0"
  }, "Send a Test Email"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"], {
    name: "basic",
    validateMessages: validateMessages,
    style: {
      display: "flex",
      gap: "10px"
    },
    onFinish: e => formSendTestEmail(e)
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, {
    label: "Email",
    name: "email",
    rules: [{
      type: "email"
    }]
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_9__["default"], {
    style: {
      width: "400px"
    }
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_5__["default"].Item, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_12__["default"], {
    type: "primary",
    htmlType: "submit",
    loading: testEmailLoading
  }, "Send"))));
}

/***/ })

}]);
//# sourceMappingURL=src_components_EmailSettings_jsx.js.map