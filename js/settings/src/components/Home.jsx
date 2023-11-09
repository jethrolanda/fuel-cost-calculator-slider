import React, { useEffect, useState, useRef } from 'react';
import { Table, Divider, Button, Modal, Input, Space, Popconfirm, notification } from 'antd';
import { FilePdfOutlined, SearchOutlined, DeleteOutlined } from '@ant-design/icons';
import Highlighter from 'react-highlight-words';
import {
  loaded,
  pagination,
  fuel_savings_data,
  fetchFuelSavingsData,
  setPagination,
  deleteItem
} from '../store/reducer/homeSlice';
import { useSelector, useDispatch } from 'react-redux';

const Home = () => {

  const [searchText, setSearchText] = useState('');
  const [searchedColumn, setSearchedColumn] = useState('');
  const searchInput = useRef(null);
  const handleSearch = (selectedKeys, confirm, dataIndex) => {
    confirm();
    setSearchText(selectedKeys[0]);
    setSearchedColumn(dataIndex);
  };
  const handleReset = (clearFilters) => {
    clearFilters();
    setSearchText('');
  };

  const [loading, setLoading] = useState(false);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [pdfURL, setPDFURL] = useState('');

  const [api, contextHolder] = notification.useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description,
    });
  };

  const dispatch = useDispatch();
  let fetched = useSelector(loaded);
  let data = useSelector(fuel_savings_data);
  let paginationData = useSelector(pagination);
  
  const showModal = (text) => {
    setPDFURL(text);
    setIsModalOpen(true);
  };

  const handleOk = () => {
    setIsModalOpen(false);
  };

  const handleCancel = () => {
    setIsModalOpen(false);
  };

  const getColumnSearchProps = (dataIndex) => ({
    filterDropdown: ({ setSelectedKeys, selectedKeys, confirm, clearFilters, close }) => (
      <div
        style={{
          padding: 8,
        }}
        onKeyDown={(e) => e.stopPropagation()}
      >
        <Input
          ref={searchInput}
          placeholder={`Search ${dataIndex}`}
          value={selectedKeys[0]}
          onChange={(e) => setSelectedKeys(e.target.value ? [e.target.value] : [])}
          onPressEnter={() => handleSearch(selectedKeys, confirm, dataIndex)}
          style={{
            marginBottom: 8,
            display: 'block',
          }}
        />
        <Space>
          <Button
            type="primary"
            onClick={() => handleSearch(selectedKeys, confirm, dataIndex)}
            icon={<SearchOutlined />}
            size="small"
            style={{
              width: 90,
            }}
          >
            Search
          </Button>
          <Button
            onClick={() => clearFilters && handleReset(clearFilters)}
            size="small"
            style={{
              width: 90,
            }}
          >
            Reset
          </Button>
          <Button
            type="link"
            size="small"
            onClick={() => {
              confirm({
                closeDropdown: false,
              });
              setSearchText(selectedKeys[0]);
              setSearchedColumn(dataIndex);
            }}
          >
            Filter
          </Button>
          <Button
            type="link"
            size="small"
            onClick={() => {
              close();
            }}
          >
            close
          </Button>
        </Space>
      </div>
    ),
    filterIcon: (filtered) => (
      <SearchOutlined
        style={{
          color: filtered ? '#1677ff' : undefined,
        }}
      />
    ),
    onFilter: (value, record) =>
      record[dataIndex].toString().toLowerCase().includes(value.toLowerCase()),
    onFilterDropdownOpenChange: (visible) => {
      if (visible) {
        setTimeout(() => searchInput.current?.select(), 100);
      }
    },
    render: (text) =>
      searchedColumn === dataIndex ? (
        <Highlighter
          highlightStyle={{
            backgroundColor: '#ffc069',
            padding: 0,
          }}
          searchWords={[searchText]}
          autoEscape
          textToHighlight={text ? text.toString() : ''}
        />
      ) : (
        text
      ),
  });

  const confirm = (id) => {
    console.log(id)
    
    dispatch(deleteItem({ id, cb: (data) => {
      if(data?.status === 'success')
        openNotificationWithIcon('success', 'Success', data?.message);
      else
        openNotificationWithIcon('error', 'Error', data?.message);
    }}))
  };

  const columns = [
    {
      title: 'Name',
      dataIndex: 'name',
      key: 'name',
      sorter: (a, b) => a.name.localeCompare(b.name),
      ...getColumnSearchProps('name'),
    },
    {
      title: 'Email',
      dataIndex: 'email',
      key: 'email',
      sorter: (a, b) => a.email.localeCompare(b.email),
      ...getColumnSearchProps('email'),
    },
    {
      title: 'Date',
      dataIndex: 'date',
      key: 'date',
      sorter: (a, b) => new Date(a.date) - new Date(b.date),
    },
    {
      title: 'Action',
      dataIndex: 'pdf_url',
      key: 'pdf_url',
      render: (text,record) => <>
        <Space>
          <a href="#" onClick={() => showModal(text)}><FilePdfOutlined /></a>
          <Popconfirm
            title="Delete this item"
            description="Are you sure to delete this item?"
            onConfirm={()=>confirm(record?.id)}
            okText="Yes"
            cancelText="No"
          >
            <a href="#"><DeleteOutlined style={{color:'red'}}/></a>
          </Popconfirm>
          
        </Space>
      </>,
      
    }
  ];
  
  useEffect(()=> {
    if(fetched === false) {
      setLoading(true);
      dispatch(fetchFuelSavingsData({cb: (data) => {setLoading(false);}}))
    }
  }, [fetched]);
  
  return <>
          {contextHolder}
          <Divider orientation="left" orientationMargin="0">
            PDF Report
          </Divider>
          <Table 
            loading={loading} 
            columns={columns} 
            dataSource={data} 
            pagination={{
              ...paginationData,
              showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} items`,
              position: ['bottomCenter'],
              'onChange': (page, pageSize) => {
                dispatch(setPagination({
                  ...paginationData,
                  current: page
                }));
                // console.log(page, pageSize)
              },
            }}
          />
          <Modal title="PDF Report" open={isModalOpen} onOk={handleOk} onCancel={handleCancel} width={1200} footer={null}>
            <iframe src={pdfURL} width="100%" height="1056"></iframe>
          </Modal>
        </>; 
};

export default React.memo(Home);