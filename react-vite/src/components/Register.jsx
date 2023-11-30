import React, { useState } from "react";
import { useNavigate } from "react-router";

const Register = () => {
  // registration
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [mobile, setMobile] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();

  async function save() {
    let item = { name, email, mobile, password };
    // console.warn(item);
    let result = await fetch("http://127.0.0.1:8000/api/register-user", {
      method: "POST",
      headers: { "Content-type": "application/json" },
      body: JSON.stringify(item),
    });
    result = await result.json();
    console.warn("result", result);
    navigate("/thanks");
  }

  return (
    <div className="col-sm-6 offset-sm-3">
      <h1>Register</h1>
      <input
        type="text"
        className="form-control"
        placeholder="Enter Name"
        value={name}
        onChange={(e) => setName(e.target.value)}
      />
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
        type="text"
        className="form-control"
        placeholder="Enter Mobile"
        value={mobile}
        onChange={(e) => setMobile(e.target.value)}
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
      <button onClick={save} className="btn btn-primary">
        Register
      </button>
    </div>
  );
};

export default Register;
