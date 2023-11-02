import React, { useEffect, useState, useRef } from 'react';
import { Table, Divider, Button, Modal, Input, Space } from 'antd';
import { FilePdfOutlined, SearchOutlined } from '@ant-design/icons';
import Highlighter from 'react-highlight-words';
import {
  loaded,
  pagination,
  fuel_savings_data,
  fetchFuelSavingsData,
  setPagination
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
      title: 'PDF',
      dataIndex: 'pdf_url',
      key: 'pdf_url',
      render: (text) => <a href="#"onClick={() =>showModal(text)}><FilePdfOutlined /></a>,
      
    }
  ];
  
  useEffect(()=> {
    if(fetched === false) {
      setLoading(true);
      dispatch(fetchFuelSavingsData({cb: (data) => {setLoading(false);}}))
    }
  }, [fetched]);
  
  return <>
          <Divider orientation="left" orientationMargin="0">
            PDF Report
          </Divider>
          <Table 
            loading={loading} 
            columns={columns} 
            dataSource={data} 
            pagination={{
              ...paginationData,
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