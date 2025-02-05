import Menu from './components/Menu'
import Home from './pages/Home'
import CountriesListing from './pages/CountriesListing'
import ContentListing from './pages/ContentListing'
import NotFound from './pages/NotFound'
import Footer from './components/Footer'
import { Routes, Route } from "react-router-dom"
import SignIn from './components/SignIn'
 
/**
*  App
*
*  This is the main component that houses other components 
*  that are intended for global usage.
*
*  @author Luke Walpole W20020794
*/

function App() {

  return (
    <>
      <SignIn />
      <Menu />
      <Routes>
        <Route path="/" element={<Home />}/>
        <Route path="/country" element={<CountriesListing />}/>
        <Route path="/content" element={<ContentListing />}/>
        <Route path="*" element={<NotFound/>}/>
      </Routes>
      <Footer />
    </>
  )
}

export default App