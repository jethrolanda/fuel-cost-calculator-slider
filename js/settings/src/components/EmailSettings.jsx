import { useState, useEffect } from 'react'
import ReactQuill from 'react-quill';
import { Button, Form, Input, notification } from 'antd';
import 'react-quill/dist/quill.snow.css';

import {
  subject,
  body,
  fetchEmailValues,
  saveEmailValues
} from '../store/reducer/emailSlice';
import { useSelector, useDispatch } from 'react-redux';

export default function EmailSettings() {

  const [loading, setLoading] = useState(false);
  const [form] = Form.useForm();

  const [api, contextHolder] = notification.useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description,
    });
  };
  
  const dispatch = useDispatch();
  let email_subject = useSelector(subject);
  let email_body = useSelector(body);


  const modules = {
    toolbar: [
      [{ 'header': [1, 2, false] }],
      ['bold', 'italic', 'underline','strike', 'blockquote'],
      [{'list': 'ordered'}, {'list': 'bullet'}, {'indent': '-1'}, {'indent': '+1'}],
      ['link'], //'image'
      // ['clean']
    ],
    clipboard: {
      matchVisual: false
    },
  }

  const formats = [
    'header',
    'bold', 'italic', 'underline', 'strike', 'blockquote',
    'list', 'bullet', 'indent',
    'link', 'image'
  ];

  const validateMessages = {
    required: '${label} is required!'
  };

  const errorCheck = () => {
    const fields = form.getFieldsValue();
    const bodyValue = fields.body.replace(/(<([^>]+)>)/gi, "");

    if(fields.subject === "" && bodyValue === ""){
      openNotificationWithIcon('error', 'Error', 'Subject and Body are required.')
    } else if(fields.subject === "") {
      openNotificationWithIcon('error', 'Error', 'Subject is required.')
    } else if(bodyValue === "") {
      openNotificationWithIcon('error', 'Error', 'Body is required.')
    }

  }

  const formSubmit = (values) => {
    setLoading(true);
    dispatch(saveEmailValues({values, cb: (data) => {
      setLoading(false);
      if(data.status==='success') {
        openNotificationWithIcon('success', 'Success', 'Successfully saved.')
      } else {
        openNotificationWithIcon('error', 'Error', data?.message)
      }
    }}))
  }

  useEffect(()=> {
    dispatch(fetchEmailValues())
  }, []);

  useEffect(()=>{
    form.setFieldsValue({
      subject: email_subject,
      body: email_body
    });
  },[email_subject, email_body]);
  
  return (
    <>
    {contextHolder}
      <Form
        form = {form}
        layout="vertical" 
        validateMessages={validateMessages}
        onFinish={(e)=>formSubmit(e)}
      >
        <h3>Email Settings</h3>
        <Form.Item
          label="Subject"
          name="subject"
          rules={[
            {
              required: true,
            },
          ]}
        >
          <Input/>
        </Form.Item>

        <Form.Item
          label="Body"
          name="body"
          rules={[
            {
              required: true,
            }, {
              message: 'Body is required!',
              validator: (_, value) => {
                if (value.replace(/(<([^>]+)>)/gi, "")) {
                  return Promise.resolve();
                } else {
                  return Promise.reject('Some message here');
                }
               }
             }
          ]}
        >
          <ReactQuill theme="snow" modules={modules} formats={formats}/>
        </Form.Item>

        <Form.Item label=" ">
          <Button type="primary" htmlType="submit" onClick={()=>errorCheck()} loading={loading}>
            Save
          </Button>
        </Form.Item>
      </Form>
    </>
  )
}
