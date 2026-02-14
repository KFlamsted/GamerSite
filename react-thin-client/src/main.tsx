import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.tsx'
import { SocialsProvider } from './context/SocialsContext.tsx'

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <SocialsProvider>
      <App />
    </SocialsProvider>
  </StrictMode>,
)
