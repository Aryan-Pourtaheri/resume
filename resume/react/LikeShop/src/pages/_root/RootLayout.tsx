import { Outlet, useLocation } from "react-router-dom";
import Navigation from "./Navigation";
import Footer from "./pages/Footer";

const RootLayout = () => {
  const location = useLocation(); // Get the current route.

  // Define routes where the footer should not be displayed.
  const hideFooterRoutes = ["/shopping"];

  // Check if the current route matches one of the routes to hide the footer.
  const shouldHideFooter = hideFooterRoutes.includes(location.pathname);

  return (
    <>
      <div className="min-w-full">
        <Navigation />
        <Outlet />
        {/* Conditionally render Footer */}
        {!shouldHideFooter && <Footer />}
      </div>
    </>
  );
};

export default RootLayout;
