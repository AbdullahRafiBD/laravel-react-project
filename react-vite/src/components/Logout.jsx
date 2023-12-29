import { useEffect } from "react";
import { useNavigate } from "react-router";

const Logout = () => {
  const navigate = useNavigate();

  function logout() {
    localStorage.clear();
    navigate("/login");
    window.location.reload();
  }

  useEffect(() => {
    logout();
  }, []);

  return <div>Logout</div>;
};

export default Logout;
