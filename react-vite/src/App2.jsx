import Function from "./Function";
import Test1 from "./Function";
import Home from "./Home";
import User from "./User";

function App() {
  return (
    <>
      <Function text="This is functional Components" />
      <Test1 text="This is test1 functional Components" />

      <User
        name={{ data: "Abdullah" }}
        address={{ data: "90/2 dhanmondi" }}
      ></User>
      <User
        name={{ data: "shihab" }}
        address={{ data: "90/2 mogbazar" }}
      ></User>
      <User name={{ data: "Rafi" }} address={{ data: "90/2 kolabagan" }}></User>

      {/* Single data for class  */}
      {/* <Home text={"This is Home Class Components"}></Home> */}

      {/* Multiple data for class  */}
      <Home name={{ data: "kasem" }} address={{ data: "90/2 mogbazar" }}></Home>
      <Home name={{ data: "sadi" }} address={{ data: "90/2 kolabagan" }}></Home>
    </>
  );
}

export default App;
