import { useState, useEffect } from "react";
import { Button, Form, Input, notification, Divider, Skeleton } from "antd";

import {
  loaded,
  apiKey,
  fetchHubspotAPIKey,
  saveHubspotAPIKey
} from "../store/reducer/hubspotSlice";
import { useSelector, useDispatch } from "react-redux";

const HubspotSettings = () => {
  const [loading, setLoading] = useState(false);
  const [api, contextHolder] = notification.useNotification();
  const openNotificationWithIcon = (type, message, description) => {
    api[type]({
      message,
      description
    });
  };
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  let fetched = useSelector(loaded);
  let api_key = useSelector(apiKey);

  const validateMessages = {
    required: "${label} is required!"
  };

  const formSubmit = (values) => {
    setLoading(true);
    dispatch(
      saveHubspotAPIKey({
        values,
        cb: (data) => {
          setLoading(false);
          if (data.status === "success") {
            openNotificationWithIcon(
              "success",
              "Success",
              "Successfully saved."
            );
          } else {
            openNotificationWithIcon("error", "Error", data?.message);
          }
        }
      })
    );
  };

  const errorCheck = () => {
    const fields = form.getFieldsValue();

    if (fields.site_key === "" && fields.secret_key === "") {
      openNotificationWithIcon(
        "error",
        "Error",
        "Site Key and Secret Key are required."
      );
    } else if (fields.site_key === "") {
      openNotificationWithIcon("error", "Error", "Site Key is required.");
    } else if (fields.secret_key === "") {
      openNotificationWithIcon("error", "Error", "Secret Key is required.");
    }
  };

  useEffect(() => {
    if (fetched === false) dispatch(fetchHubspotAPIKey());
  }, [fetched]);

  useEffect(() => {
    form.setFieldsValue({
      api_key
    });
  }, [api_key]);

  return fetched === false ? (
    <Skeleton />
  ) : (
    <>
      {contextHolder}
      <Divider orientation="left" orientationMargin="0">
        Hubspot API Settings
      </Divider>
      <p>
        Create api key in hubspot private app. See Link{" "}
        <a
          target="_blank"
          href="https://developers.hubspot.com/docs/api/private-apps"
        >
          here
        </a>
        .
      </p>
      <Form
        form={form}
        layout="vertical"
        style={{
          maxWidth: 600
        }}
        validateMessages={validateMessages}
        onFinish={(e) => formSubmit(e)}
      >
        <Form.Item
          label="API Key"
          name="api_key"
          rules={[
            {
              required: true
            }
          ]}
        >
          <Input />
        </Form.Item>

        <Form.Item label=" ">
          <Button
            type="primary"
            htmlType="submit"
            onClick={() => errorCheck()}
            loading={loading}
          >
            Save
          </Button>
        </Form.Item>
      </Form>
    </>
  );
};

export default HubspotSettings;
