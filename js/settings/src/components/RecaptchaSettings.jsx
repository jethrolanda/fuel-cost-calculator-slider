import {useState, useEffect} from 'react';
import { Button, Form, Input, notification } from 'antd';

import {
  siteKey,
  secretKey,
  fetchRecaptchaValues,
  saveRecaptchaValues
} from '../store/reducer/recaptchaSlice';
import { useSelector, useDispatch } from 'react-redux';

const RecaptchaSettings = () => {
  const [loading, setLoading] = useState(false)
  const [api, contextHolder] = notification.useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description,
    });
  };
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  let site_key = useSelector(siteKey);
  let secret_key = useSelector(secretKey);

  form.setFieldsValue({
    site_key, secret_key
  });
 
  const validateMessages = {
    required: '${label} is required!'
  };
  
  const formSubmit = (values) => {
    setLoading(true);
    dispatch(saveRecaptchaValues({values, cb: (data) => {
      setLoading(false);
      if(data.status==='success') {
        openNotificationWithIcon('success', 'Success', 'Successfully saved.')
      } else {
        openNotificationWithIcon('error', 'Error', data?.message)
      }
    }}))
  }

  const errorCheck = () => {
    const fields = form.getFieldsValue();

    if(fields.site_key === "" && fields.secret_key === ""){
      openNotificationWithIcon('error', 'Error', 'Site Key and Secret Key are required.')
    } else if(fields.site_key === "") {
      openNotificationWithIcon('error', 'Error', 'Site Key is required.')
    } else if(fields.secret_key === "") {
      openNotificationWithIcon('error', 'Error', 'Secret Key is required.')
    }

  }

  useEffect(()=> {
    dispatch(fetchRecaptchaValues())
  }, []);

  return <>
      {contextHolder}
      <Form
          form = {form}
          layout="vertical"
          style={{
            maxWidth: 600,
          }}
          validateMessages={validateMessages}
          onFinish={(e)=>formSubmit(e)}
        >
          <h3>Recaptcha Settings</h3>
          <Form.Item
            label="Site Key"
            name="site_key"
            rules={[
              {
                required: true,
              },
            ]}
          >
            <Input value={site_key}/>
          </Form.Item>

          <Form.Item
            label="Secret Key"
            name="secret_key"
            rules={[
              {
                required: true,
              },
            ]}
          >
            <Input value={secret_key}/>
          </Form.Item>

          <Form.Item label=" ">
            <Button type="primary" htmlType="submit" onClick={()=>errorCheck()} loading={loading}>
              Save
            </Button>
          </Form.Item>
        </Form>
    </>
};

export default RecaptchaSettings;