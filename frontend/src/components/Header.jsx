const Header = () => {
  return (
    <header className="bg-red-600 text-white p-4 flex justify-between items-center">
      <div className="flex items-center">
        <img
          src="./assets/logo-mfs-top.png"
          alt="Logotipo MSF"
          className="h-10 mr-4"
        />
        <h1 className="text-xl font-bold">Médicos Sin Fronteras</h1>
      </div>
      <div className="text-sm">
        <span className="cursor-pointer hover:underline">ES</span> |{" "}
        <span className="cursor-pointer hover:underline">EN</span>
      </div>
    </header>
  );
};

export default Header;
