import React, { useState } from 'react';
import { HomeOutlined, AppstoreOutlined, MailOutlined } from '@ant-design/icons';
import { Menu, Layout } from 'antd';
const { Content } = Layout;
import RecaptchaSettings from './components/RecaptchaSettings';
import EmailSettings from './components/EmailSettings';
import Home from './components/Home';
 
const items = [
  {
    label: 'Home',
    key: 'home',
    icon: <HomeOutlined />,
  },
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
  if(current === 'home'){
    return <Home/>
  } else if(current === 'mail'){
    return <EmailSettings/>
  } else {
    return <RecaptchaSettings/>
  }
  
}
const App = () => {
  const [current, setCurrent] = useState('home');
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