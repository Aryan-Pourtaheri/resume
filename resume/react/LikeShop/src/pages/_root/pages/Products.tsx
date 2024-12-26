import ProductCart from "@/components/shared/ProductCard";
import { Product } from "@/types/products";
import { useInfiniteQuery } from "@tanstack/react-query";
import { useState } from "react";

const Products = () => {
  const [searchQuery, setSearchQuery] = useState("");

  const fetchProducts = async () => {
    const res = await fetch(`https://fakestoreapi.com/products`);
    return res.json();
  };

  const { data } = useInfiniteQuery({
    queryKey: ["product"],
    queryFn: fetchProducts,
    initialPageParam: 1,
    getNextPageParam: (lastPage) => {
      return lastPage;
    },
  });

  const filteredProducts = data?.pages.flat().filter((product: Product) =>
    product.title.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <div className="mt-28 px-2 lg:px-6 mb-10">
      <div className="mb-6 flex justify-center">
        <input
          type="text"
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          placeholder="Search for products..."
          className="border border-gray-300 rounded-full px-5 py-3 w-full max-w-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
        />
      </div>

      <div className="flex justify-center">
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          {filteredProducts?.map((product: Product) => (
            <ProductCart key={product.id} product={product} />
          )) || <div className="mb-80">No products found</div>}
        </div>
      </div>
    </div>
  );
};

export default Products;
