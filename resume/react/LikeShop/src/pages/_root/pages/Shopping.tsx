import { useEffect, useState } from 'react';
import { useCart } from '@/lib/cart/CartContext';
import { Product } from 'src/types/products';
import { Button } from '@/components/ui/button';
import CartProductCard from '@/components/shared/cartproductcard';
import Loader from '@/components/shared/Loader';

const Shopping = () => {
  const { productIds, clearCart } = useCart();
  const [cartProducts, setCartProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
    
  const handleClearCart = () => {
    clearCart();
    alert('Cart has been emptied.');
  };

  const fetchProductDetails = async (productId: string) => {
    try {
      const response = await fetch(`https://fakestoreapi.com/products/${productId}`);
      if (!response.ok) {
        throw new Error(`Failed to fetch product details for product ID ${productId}`);
      }


      const data = await response.json();
      
      if (!data) {
        throw new Error('Invalid response data');
      }

      return data;
    } catch (error) {
      console.error('Error fetching product details:', error);
      return null;
    }
  };

  useEffect(() => {
    const fetchCartProducts = async () => {
      setLoading(true);
      try {
        const products = await Promise.all(
          productIds.map(async (productId) => {
            if (typeof productId.id !== 'number') {
              console.error('Invalid product ID:', productId.id);
              return null;
            }
            const product = await fetchProductDetails(productId.id);
            return product || null;
          })
        );

        setCartProducts(products.filter((product) => product !== null));
      } catch (error) {
        console.error('Error fetching cart products:', error);
      } finally {
        setLoading(false);
      }
    };

    if (productIds.length > 0) {
      fetchCartProducts();
    } else {
      setCartProducts([]);
      setLoading(false);
    }
  }, [productIds]);

  if (loading) {
    return <Loader/>;
  }

  if (cartProducts.length === 0) {
    return <div>Your cart is empty.</div>;
  }

  const handlePurchase = () => {
    alert('Purchase successful!');
  };

  return (
    <div className="container mt-20 mx-auto px-4 py-6">
      <h1 className="text-2xl font-bold mb-6">Shopping Cart</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {cartProducts.map((product) => (
          <CartProductCard key={product.id} product={product} />
        ))}
        
      </div>
      <div className="mt-6 flex justify-end">
        <Button onClick={handlePurchase} className="bg-blue-500 text-white px-6 py-3 rounded-md">
          Purchase
        </Button>

        <button onClick={handleClearCart} className="ml-5 bg-red-500 text-white px-4 py-2 rounded-md">
          Clear Cart
        </button>
      </div>
    </div>
  );
};

export default Shopping;
