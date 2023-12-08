const Account = () => {
  let user = JSON.parse(localStorage.getItem("user"));

  return (
    <>
      {localStorage.getItem("user") ? (
        <>Welcome {user.userDetails.name}</>
      ) : null}
    </>
  );
};

export default Account;
