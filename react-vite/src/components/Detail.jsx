import axios from "axios";
import { useEffect, useState } from "react";
import { Link, useSearchParams } from "react-router-dom";

const Detail = () => {
  const [product, setProduct] = useState([]);
  const [searchParams, setSearchParams] = useSearchParams();

  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/detail/" + searchParams.get("id"))
      .then((response) => setProduct(response.data["product"]));
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div align="center">
      {product.map((productObj) => {
        return (
          <div key={productObj.id}>
            <h3>{productObj.product_name}</h3>
            <img src={productObj.product_image} />
            <h4>Code: {productObj.product_code}</h4>
            <h4 style={{ color: "red" }}>Price: {productObj.final_price}</h4>
            <h4>
              {productObj.brand.name}/{" "}
              <Link to={"/listing?url=" + productObj.category.url}>
                {productObj.category.category_name}
              </Link>
            </h4>
            <h5 style={{ color: "blue" }}>
              {productObj.product_short_description}
            </h5>
          </div>
        );
      })}
    </div>
  );
};

export default Detail;
