import { createSlice } from '@reduxjs/toolkit'
import axios from '../../helpers/axios';
const qs = require("qs");

// Email state
export const emailSlice = createSlice({
  name: 'emailState',
  initialState: {
    loaded: false,
    subject: '',
    cc: '',
    body: ''
  },
  reducers: {
    setLoaded: (state, action) => {
      state.loaded = action.payload;
    },
    setSubject: (state, action) => {
      state.subject = action.payload;
    },
    setCC: (state, action) => {
      state.cc = action.payload;
    },
    setBody: (state, action) => {
      state.body = action.payload;
    },
  },
})

export const { setLoaded, setSubject, setCC, setBody } = emailSlice.actions

// The function below is called a selector and allows us to select a value from
// the state. Selectors can also be defined inline where they're used instead of
// in the slice file. For example: `useSelector((state) => state.counter.value)`
export const loaded = (state) => state.emailState.loaded
export const subject = (state) => state.emailState.subject
export const cc = (state) => state.emailState.cc
export const body = (state) => state.emailState.body

// Get email values
export const fetchEmailValues = () => (dispatch) => {
  
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_get_email_data",
    nonce: fscs_settings.settings_nonce,
    data: []
  })).then(({data}) => {
    dispatch(setLoaded(true));
    dispatch(setSubject(data?.subject));
    dispatch(setCC(data?.cc));
    dispatch(setBody(data?.body));
  });
  
}

// Save email values
export const saveEmailValues = ({values, cb}) => (dispatch) => {
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_save_email_data",
    nonce: fscs_settings.settings_nonce,
    ...values
  })).then(({data}) => {
    dispatch(setSubject(data?.subject));
    dispatch(setCC(data?.cc));
    dispatch(setBody(data?.body));
    if (typeof cb === "function") cb(data);
  });
  
}

// Send test email
export const sendTestEmail = ({email, cb}) => (dispatch) => {
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_send_test_email",
    nonce: fscs_settings.settings_nonce,
    email
  })).then(({data}) => {
    if (typeof cb === "function") cb(data);
  });
  
}

export default emailSlice.reducer