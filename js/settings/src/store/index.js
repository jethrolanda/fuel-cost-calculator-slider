import { configureStore } from '@reduxjs/toolkit'
import emailReducer from './reducer/emailSlice'
import recaptchaReducer from './reducer/recaptchaSlice'

export default configureStore({
  reducer: {
    emailState: emailReducer,
    recaptchaState: recaptchaReducer
  },
})