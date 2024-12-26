import { createContext, useContext, useState, useEffect, ReactNode } from 'react';

interface CartContextType {
  productIds: string[];
  addToCart: (productId: string) => void;
  removeFromCart: (productId: string) => void;
  clearCart: () => void;
  cartCount: number;
}

const CartContext = createContext<CartContextType | undefined>(undefined);

export const CartProvider = ({ children }: { children: ReactNode }) => {
  const [productIds, setProductIds] = useState<string[]>(() => {
    const savedIds = localStorage.getItem('productIds');
    return savedIds ? JSON.parse(savedIds) : [];
  });

  useEffect(() => {
    localStorage.setItem('productIds', JSON.stringify(productIds));
  }, [productIds]);

  const addToCart = (productId: string) => {
    setProductIds((prevIds) => {
      if (prevIds.includes(productId)) {
        return prevIds;
      }
      const updatedIds = [...prevIds, productId];
      localStorage.setItem('productIds', JSON.stringify(updatedIds));
      return updatedIds;
    });
  };

  const removeFromCart = (productId: string) => {
    setProductIds((prevIds) => {
      const updatedIds = prevIds.filter((id) => id['id'] !== productId);
      localStorage.setItem('productIds', JSON.stringify(updatedIds));
      return updatedIds;
    });
  };

  const clearCart = () => {
    setProductIds([]);
    localStorage.removeItem('productIds');
  };


  const cartCount = productIds.length;

  return (
    <CartContext.Provider value={{ productIds, addToCart, removeFromCart, clearCart, cartCount }}>
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => {
  const context = useContext(CartContext);
  if (!context) {
    throw new Error('useCart must be used within a CartProvider');
  }
  return context;
};