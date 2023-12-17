import { Route, Router, Routes } from "react-router";
import Function from "./Function";
import Test1 from "./Function";
import User from "./User";
import About from "./components/About";
import Home from "./components/Home";
import Contact from "./components/Contact";
import Navbar from "./components/Navbar";
import Register from "./components/Register";
import Thanks from "./components/Thanks";
import Login from "./components/Login";
import Account from "./components/Account";
import Logout from "./components/Logout";
import Shop from "./components/Shop";
import Listing from "./components/Listing";
import Detail from "./components/Detail";
import Cart from "./components/Cart";

function App() {
  return (
    <>
      <Navbar></Navbar>
      <Routes>
        <Route path="/" element={<Home></Home>}></Route>
        <Route path="/Contact" element={<Contact></Contact>}></Route>
        <Route path="/register" element={<Register></Register>}></Route>
        <Route path="/login" element={<Login></Login>}></Route>
        <Route path="/logout" element={<Logout></Logout>}></Route>
        <Route path="/thanks" element={<Thanks></Thanks>}></Route>
        <Route path="/account" element={<Account></Account>}></Route>
        <Route path="/about" element={<About></About>}></Route>
        <Route path="/shop" element={<Shop></Shop>}></Route>
        <Route path="/listing" element={<Listing></Listing>}></Route>
        <Route path="/detail" element={<Detail></Detail>}></Route>
        <Route path="/cart" element={<Cart></Cart>}></Route>
      </Routes>
    </>
  );
}

export default App;
