import React from 'react';
import { Product } from 'src/types/products';
import { Button } from '@/components/ui/button';
import { useCart } from '@/lib/cart/CartContext';

interface CartProductCardProps {
  product: Product;
}

const CartProductCard: React.FC<CartProductCardProps> = ({ product }) => {
  const { removeFromCart } = useCart();
  
  return (
    <div className="bg-white p-4 rounded-lg shadow-md flex items-center space-x-4">
      <img src={product.image || '/default-product.png'} alt={product.title} className="w-24 h-24 object-cover rounded-md" /> 
      <div className="flex-1">
        <h3 className="text-lg font-semibold">{product.title}</h3>
        <p className="text-sm text-gray-500">Category: {product.category || 'N/A'}</p>
      </div>
      <Button
        onClick={() => removeFromCart(product.id)}
        className="bg-red-500 text-white px-4 py-2 rounded-md"
      >
        Remove
      </Button>
    </div>
  );
};

export default CartProductCard;