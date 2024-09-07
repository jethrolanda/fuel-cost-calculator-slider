import React, { useState, lazy, Suspense } from "react";
import {
  HomeOutlined,
  AppstoreOutlined,
  MailOutlined,
  ReadOutlined
} from "@ant-design/icons";
import { Menu, Layout } from "antd";
const { Content } = Layout;

const RecaptchaSettings = lazy(() => import("./components/RecaptchaSettings"));
const EmailSettings = lazy(() => import("./components/EmailSettings"));
const Home = lazy(() => import("./components/Home"));
const HubspotSettings = lazy(() => import("./components/HubspotSettings"));
const items = [
  {
    label: "Home",
    key: "home",
    icon: <HomeOutlined />
  },
  {
    label: "Email",
    key: "mail",
    icon: <MailOutlined />
  },
  {
    label: "Recaptcha",
    key: "recaptcha",
    icon: <AppstoreOutlined />
  },
  {
    label: "Hubspot API",
    key: "hubspot",
    icon: <ReadOutlined />
  }
];

const LoadSettingsPage = ({ current }) => {
  if (current === "home") {
    return (
      <Suspense fallback={"Loading..."}>
        <Home />
      </Suspense>
    );
  } else if (current === "mail") {
    return (
      <Suspense fallback={"Loading..."}>
        <EmailSettings />
      </Suspense>
    );
  } else if (current === "recaptcha") {
    return (
      <Suspense fallback={"Loading..."}>
        <RecaptchaSettings />
      </Suspense>
    );
  } else {
    return (
      <Suspense fallback={"Loading..."}>
        <HubspotSettings />
      </Suspense>
    );
  }
};
const App = () => {
  const [current, setCurrent] = useState("home");
  const onClick = (e) => {
    setCurrent(e.key);
  };

  return (
    <>
      <Menu
        theme="dark"
        onClick={onClick}
        selectedKeys={[current]}
        mode="horizontal"
        items={items}
      />
      <Content
        style={{ padding: "10px 20px", marginTop: "10px", background: "#fff" }}
      >
        <div className="site-layout-content">
          <LoadSettingsPage current={current} />
        </div>
      </Content>
    </>
  );
};
export default React.memo(App);
