import logo from './logo.svg';
import './App.css';
import Button from 'react-bootstrap/Button';
import { useEffect, useState } from 'react';
import axios from 'axios';


function App() {

  const [count, setCount] = useState(0);

  // declare user variable to fetch user data from database vai axios
  const [user, setUser] = useState([]);

  const fetchData = () => {
    return axios.get('http://127.0.0.1:8000/api/users')
      .then((response) => setUser(response.data['users']));
  }

  useEffect(() => {
    fetchData()
  }, [])


  return (
    <div className="App">
      <span>{count}</span>
      <Button>hello</Button>
      <div>
        <p>You clicked {count} times</p>
        <button onClick={() => setCount(count + 1)}>
          Click me
        </button>
      </div>

      <h1>user data</h1>
      <ul>
        {user && user.length > 0 && user.map((userObj, index) => (
          <li key={userObj.id}>{userObj.name}</li>
        ))}
      </ul>

    </div>
  );
}

export default App;
