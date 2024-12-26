import { useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import Loader from "@/components/shared/Loader";
import { useCart } from "@/lib/cart/CartContext";

interface Product {
  id: string;
  title: string;
  description: string;
  price: number;
  image: string;
  category: string;
  rating: {
    rate: number;
    count: number;
  };
}

const ProductDetail = () => {
  const { productId } = useParams<{ productId: string }>();
  const [product, setProduct] = useState<Product | null>(null);
  const { addToCart } = useCart();

  useEffect(() => {
    fetch(`https://fakestoreapi.com/products/${productId}`)
      .then((response) => response.json())
      .then((data) => setProduct(data))
      .catch((error) => console.error("Error fetching product details:", error));
  }, [productId]);

  if (!product) {
    return <Loader />;
  }

  return (
    <div className="flex flex-col lg:flex-row items-center justify-center gap-12 p-6 mt-20 mb-10">
      <div className="w-full lg:w-1/2">
        <img
          src={product.image}
          alt={product.title}
          className="w-full h-full max-h-[500px] object-contain rounded-lg shadow-lg"
        />
      </div>

      <div className="w-full lg:w-1/2">
        <h1 className="text-4xl font-bold text-gray-800 mb-4">{product.title}</h1>
        <p className="text-lg text-gray-600 italic mb-2">Category: {product.category}</p>
        <p className="text-gray-700 text-lg leading-6 mb-6">{product.description}</p>
        <p className="text-2xl font-semibold text-teal-600 mb-6">${product.price}</p>
        <p className="text-md text-gray-500 mb-4">
          Rating: {product.rating.rate} ({product.rating.count} reviews)
        </p>

        <button
          onClick={() => addToCart(product)}
          className="bg-teal-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-teal-700 transition-all"
        >
          Add to Cart
        </button>
      </div>
    </div>
  );
};

export default ProductDetail;
