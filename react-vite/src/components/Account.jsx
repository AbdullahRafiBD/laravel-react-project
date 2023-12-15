import { useState } from "react";
import { useNavigate } from "react-router";

const Account = () => {
  let user = JSON.parse(localStorage.getItem("user"));

  const [id, setId] = useState(user.userDetails.id);
  const [name, setName] = useState(user.userDetails.name);
  const [address, setAddress] = useState(user.userDetails.address);
  const [city, setCity] = useState(user.userDetails.city);
  const [state, setState] = useState(user.userDetails.state);
  const [country, setCountry] = useState(user.userDetails.country);
  const [pincode, setPincode] = useState(user.userDetails.pincode);

  const navigate = useNavigate();

  async function Update() {
    if (name == "") {
      alert("Please Enter Your name");
    } else {
      let item = { id, name, address, city, state, country, pincode };
      let result = await fetch("http://127.0.0.1:8000/api/update-user", {
        method: "POST",
        headers: { "Content-type": "application/json" },
        body: JSON.stringify(item),
      });
      result = await result.json();
      // console.warn(result);
      localStorage.setItem("user", JSON.stringify(result));
      navigate("/account");
    }
  }

  return (
    <div className="container">
      {localStorage.getItem("user") ? (
        <>Welcome {user.userDetails && user.userDetails.name}</>
      ) : null}

      <div className="col-sm-6 offset-sm-3">
        <h5>Your Account Details are Below </h5>
        Name:
        <input
          className="form-control"
          type="text"
          placeholder={user.userDetails && user.userDetails.name}
          onChange={(e) => setName(e.target.value)}
          value={name}
        />
        Address:
        <input
          className="form-control"
          type="text"
          placeholder={user.userDetails && user.userDetails.address}
          onChange={(e) => setAddress(e.target.value)}
          value={address}
        />
        City:
        <input
          className="form-control"
          type="text"
          placeholder={user.userDetails && user.userDetails.city}
          onChange={(e) => setCity(e.target.value)}
          value={city}
        />
        State:
        <input
          className="form-control"
          type="text"
          placeholder={user.userDetails && user.userDetails.state}
          onChange={(e) => setState(e.target.value)}
          value={state}
        />
        Country:
        <input
          className="form-control"
          type="text"
          placeholder={user.userDetails && user.userDetails.country}
          onChange={(e) => setCountry(e.target.value)}
          value={country}
        />
        Pincode:
        <input
          className="form-control"
          type="text"
          placeholder={user.userDetails && user.userDetails.pincode}
          onChange={(e) => setPincode(e.target.value)}
          value={pincode}
        />
        <br />
        <button className="btn btn-primary" onClick={Update}>
          Update
        </button>
      </div>
    </div>
  );
};

export default Account;
