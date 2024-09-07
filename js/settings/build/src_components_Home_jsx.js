"use strict";
(self["webpackChunksettings"] = self["webpackChunksettings"] || []).push([["src_components_Home_jsx"],{

/***/ "./src/components/Home.jsx":
/*!*********************************!*\
  !*** ./src/components/Home.jsx ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/notification/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/input/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/space/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/button/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/popconfirm/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/divider/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/table/index.js");
/* harmony import */ var antd__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! antd */ "./node_modules/antd/es/modal/index.js");
/* harmony import */ var _ant_design_icons__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @ant-design/icons */ "./node_modules/@ant-design/icons/es/icons/SearchOutlined.js");
/* harmony import */ var _ant_design_icons__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @ant-design/icons */ "./node_modules/@ant-design/icons/es/icons/FilePdfOutlined.js");
/* harmony import */ var _ant_design_icons__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @ant-design/icons */ "./node_modules/@ant-design/icons/es/icons/DeleteOutlined.js");
/* harmony import */ var _ant_design_icons__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @ant-design/icons */ "./node_modules/@ant-design/icons/es/icons/DownloadOutlined.js");
/* harmony import */ var react_highlight_words__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-highlight-words */ "./node_modules/react-highlight-words/dist/main.js");
/* harmony import */ var react_highlight_words__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_highlight_words__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../store/reducer/homeSlice */ "./src/store/reducer/homeSlice.js");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var react_csv__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react-csv */ "./node_modules/react-csv/index.js");








const Home = () => {
  const [searchText, setSearchText] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  const [searchedColumn, setSearchedColumn] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  const searchInput = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const handleSearch = (selectedKeys, confirm, dataIndex) => {
    confirm();
    setSearchText(selectedKeys[0]);
    setSearchedColumn(dataIndex);
  };
  const handleReset = clearFilters => {
    clearFilters();
    setSearchText("");
  };
  const [loading, setLoading] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [isModalOpen, setIsModalOpen] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [pdfURL, setPDFURL] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  const [api, contextHolder] = antd__WEBPACK_IMPORTED_MODULE_5__["default"].useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description
    });
  };
  const dispatch = (0,react_redux__WEBPACK_IMPORTED_MODULE_3__.useDispatch)();
  let fetched = (0,react_redux__WEBPACK_IMPORTED_MODULE_3__.useSelector)(_store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__.loaded);
  let data = (0,react_redux__WEBPACK_IMPORTED_MODULE_3__.useSelector)(_store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__.fuel_savings_data);
  let paginationData = (0,react_redux__WEBPACK_IMPORTED_MODULE_3__.useSelector)(_store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__.pagination);
  const showModal = text => {
    setPDFURL(text);
    setIsModalOpen(true);
  };
  const handleOk = () => {
    setIsModalOpen(false);
  };
  const handleCancel = () => {
    setIsModalOpen(false);
  };
  const getColumnSearchProps = dataIndex => ({
    filterDropdown: ({
      setSelectedKeys,
      selectedKeys,
      confirm,
      clearFilters,
      close
    }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        padding: 8
      },
      onKeyDown: e => e.stopPropagation()
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_6__["default"], {
      ref: searchInput,
      placeholder: `Search ${dataIndex}`,
      value: selectedKeys[0],
      onChange: e => setSelectedKeys(e.target.value ? [e.target.value] : []),
      onPressEnter: () => handleSearch(selectedKeys, confirm, dataIndex),
      style: {
        marginBottom: 8,
        display: "block"
      }
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_7__["default"], null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
      type: "primary",
      onClick: () => handleSearch(selectedKeys, confirm, dataIndex),
      icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_9__["default"], null),
      size: "small",
      style: {
        width: 90
      }
    }, "Search"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
      onClick: () => clearFilters && handleReset(clearFilters),
      size: "small",
      style: {
        width: 90
      }
    }, "Reset"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
      type: "link",
      size: "small",
      onClick: () => {
        confirm({
          closeDropdown: false
        });
        setSearchText(selectedKeys[0]);
        setSearchedColumn(dataIndex);
      }
    }, "Filter"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_8__["default"], {
      type: "link",
      size: "small",
      onClick: () => {
        close();
      }
    }, "close"))),
    filterIcon: filtered => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_9__["default"], {
      style: {
        color: filtered ? "#1677ff" : undefined
      }
    }),
    onFilter: (value, record) => record[dataIndex].toString().toLowerCase().includes(value.toLowerCase()),
    onFilterDropdownOpenChange: visible => {
      if (visible) {
        setTimeout(() => searchInput.current?.select(), 100);
      }
    },
    render: text => searchedColumn === dataIndex ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)((react_highlight_words__WEBPACK_IMPORTED_MODULE_1___default()), {
      highlightStyle: {
        backgroundColor: "#ffc069",
        padding: 0
      },
      searchWords: [searchText],
      autoEscape: true,
      textToHighlight: text ? text.toString() : ""
    }) : text
  });
  const confirm = id => {
    dispatch((0,_store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__.deleteItem)({
      id,
      cb: data => {
        if (data?.status === "success") {
          openNotificationWithIcon("success", "Success", data?.message);
        } else openNotificationWithIcon("error", "Error", data?.message);
      }
    }));
  };
  const columns = [{
    title: "Customer Name",
    dataIndex: "customer_name",
    key: "customer_name",
    sorter: (a, b) => a.customer_name.localeCompare(b.customer_name),
    ...getColumnSearchProps("customer_name")
  }, {
    title: "Customer Email",
    dataIndex: "customer_email",
    key: "customer_email",
    sorter: (a, b) => a.customer_email.localeCompare(b.customer_email),
    ...getColumnSearchProps("customer_email")
  }, {
    title: "Salesperson Name",
    dataIndex: "salesperson_name",
    key: "salesperson_name",
    sorter: (a, b) => a.salesperson_name.localeCompare(b.salesperson_name),
    ...getColumnSearchProps("salesperson_name")
  }, {
    title: "Salesperson Email",
    dataIndex: "salesperson_email",
    key: "salesperson_email",
    sorter: (a, b) => a.salesperson_email.localeCompare(b.salesperson_email),
    ...getColumnSearchProps("salesperson_email")
  }, {
    title: "Date",
    dataIndex: "date",
    key: "date",
    sorter: (a, b) => new Date(a.date) - new Date(b.date)
  }, {
    title: "Action",
    dataIndex: "pdf_url",
    key: "pdf_url",
    render: (text, record) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_7__["default"], null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: "#",
      onClick: () => showModal(text)
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_10__["default"], null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_11__["default"], {
      title: "Delete this item",
      description: "Are you sure to delete this item?",
      onConfirm: () => confirm(record?.id),
      okText: "Yes",
      cancelText: "No"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: "#"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_12__["default"], {
      style: {
        color: "red"
      }
    })))))
  }];
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (fetched === false) {
      setLoading(true);
      dispatch((0,_store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__.fetchFuelSavingsData)({
        cb: data => {
          setLoading(false);
        }
      }));
    }
  }, [fetched]);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, contextHolder, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_13__["default"], {
    orientation: "left",
    orientationMargin: "0"
  }, "PDF Report"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_csv__WEBPACK_IMPORTED_MODULE_4__.CSVLink, {
    data: data,
    filename: "fuel-savings-report.csv",
    style: {
      float: "right",
      marginBottom: "15px"
    }
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ant_design_icons__WEBPACK_IMPORTED_MODULE_14__["default"], null), " Download CSV"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_15__["default"], {
    loading: loading,
    columns: columns,
    dataSource: data,
    pagination: {
      ...paginationData,
      showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} items`,
      position: ["bottomCenter"],
      onChange: (page, pageSize) => {
        dispatch((0,_store_reducer_homeSlice__WEBPACK_IMPORTED_MODULE_2__.setPagination)({
          ...paginationData,
          current: page
        }));
      }
    }
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(antd__WEBPACK_IMPORTED_MODULE_16__["default"], {
    title: "PDF Report",
    open: isModalOpen,
    onOk: handleOk,
    onCancel: handleCancel,
    width: 1200,
    footer: null
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("iframe", {
    src: pdfURL,
    width: "100%",
    height: "1056"
  })));
};
/* harmony default export */ __webpack_exports__["default"] = (react__WEBPACK_IMPORTED_MODULE_0___default().memo(Home));

/***/ })

}]);
//# sourceMappingURL=src_components_Home_jsx.js.map