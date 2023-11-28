import { useEffect, useState } from "react";
import reactLogo from "./assets/react.svg";
import viteLogo from "/vite.svg";
import "./App.css";
import axios from "axios";
import Home from "./Home";

function App() {
  // declare user variable to fetch user data from database vai axios
  const [user, setUser] = useState([]);

  /* 
  // via axios
  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/users")
      .then((response) => setUser(response.data["users"]));
  }; */

  // via fetch method
  const fetchData = () => {
    return (
      fetch("http://127.0.0.1:8000/api/users")
        .then((response) => response.json())
        // .then((data) => console.log(data["users"]));
        .then((data) => setUser(data["users"]))
    );
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <>
      <Home />
      <h1>user data</h1>
      <ul>
        {user &&
          user.length > 0 &&
          user.map((userObj, index) => (
            <li key={userObj.id}>
              {userObj.name} <br /> {userObj.email}
            </li>
          ))}
      </ul>
    </>
  );
}

export default App;
