const User = (prop) => {
  return (
    <div>
      <h1>{prop.name.data}</h1>
      <h3>{prop.address.data}</h3>
    </div>
  );
};

export default User;
