import { configureStore } from '@reduxjs/toolkit'
import homeReducer from './reducer/homeSlice'
import emailReducer from './reducer/emailSlice'
import recaptchaReducer from './reducer/recaptchaSlice'

export default configureStore({
  reducer: {
    homeState: homeReducer,
    emailState: emailReducer,
    recaptchaState: recaptchaReducer
  },
})