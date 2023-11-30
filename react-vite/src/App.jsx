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

function App() {
  return (
    <>
      <Navbar></Navbar>
      <Routes>
        <Route path="/" element={<Home></Home>}></Route>
        <Route path="/Contact" element={<Contact></Contact>}></Route>
        <Route path="/register" element={<Register></Register>}></Route>
        <Route path="/thanks" element={<Thanks></Thanks>}></Route>
      </Routes>
    </>
  );
}

export default App;
