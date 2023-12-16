import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

const Shop = () => {
  const [menu, setMenu] = useState([]);

  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/menu")
      .then((response) => setMenu(response.data["categories"]));
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div>
      {menu.map((menuObj) => {
        return (
          <div>
            <h2>{menuObj.name}</h2>
            {menuObj.categories.map((catObj) => {
              return (
                <Link to={"/listing?url=" + catObj.url}>
                  <h4>{catObj.category_name}</h4>
                </Link>
              );
            })}
          </div>
        );
      })}
    </div>
  );
};

export default Shop;
