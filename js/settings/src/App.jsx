import React, { useState } from 'react';
import { AppstoreOutlined, MailOutlined } from '@ant-design/icons';
import { Menu, Layout } from 'antd';
const { Content } = Layout;
import RecaptchaSettings from './components/RecaptchaSettings';
import EmailSettings from './components/EmailSettings';
 
const items = [
  {
    label: 'Email',
    key: 'mail',
    icon: <MailOutlined />,
  },
  {
    label: 'Recaptcha',
    key: 'recaptcha',
    icon: <AppstoreOutlined />,
  }
];

const LoadSettingsPage = ({current}) => {

  if(current === 'mail'){
    return <EmailSettings/>
  } else {
    return <RecaptchaSettings/>
  }
  
}
const App = () => {
  const [current, setCurrent] = useState('mail');
  const onClick = (e) => {
    setCurrent(e.key);
  };
  
  return <>
    <Menu onClick={onClick} selectedKeys={[current]} mode="horizontal" items={items} />
    <Content style={{ padding: '10px 20px', marginTop: '10px', background: '#fff'}}>
        <div className="site-layout-content">
          <LoadSettingsPage current={current}/>
        </div>
    </Content>
  
  </>;
};
export default App;