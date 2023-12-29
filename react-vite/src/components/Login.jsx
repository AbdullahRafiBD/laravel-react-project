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
    // console.warn("result", result);
    // alert(result["email"]);
    if (result["email"] == "Email is Required") {
      alert(result["email"]);
    } else if (result["email"] == "Enter a valid email") {
      alert(result["email"]);
    } else if (result["email"] == "Email does not exists") {
      alert(result["email"]);
    } else if (result["message"] == "Email is incorrect!") {
      alert(result["message"]);
    } else if (result["password"] == "Password is Required") {
      alert(result["password"]);
    } else if (result["message"] == "Password is incorrect!") {
      alert(result["message"]);
    } else {
      localStorage.setItem("user", JSON.stringify(result));
      navigate("/account");
      window.location.reload();
    }
    // navigate("/account");
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
