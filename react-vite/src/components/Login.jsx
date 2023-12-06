import { useState } from "react";
import { useNavigate } from "react-router";

const Login = () => {
  // Login
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();

  async function loginUser() {
    let item = { email, password };
    // console.warn(item);
    let result = await fetch("http://127.0.0.1:8000/api/login-user", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(item),
    });
    result = await result.json();
    console.warn("result", result);

    navigate("/account");
  }

  return (
    <div className="col-sm-6 offset-sm-3">
      <h1>Login</h1>

      <br />
      <input
        type="email"
        className="form-control"
        placeholder="Enter email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
      />
      <br />

      <input
        type="password"
        className="form-control"
        placeholder="Enter Password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
      />
      <br />
      <button onClick={loginUser} className="btn btn-primary">
        Register
      </button>
    </div>
  );
};

export default Login;
