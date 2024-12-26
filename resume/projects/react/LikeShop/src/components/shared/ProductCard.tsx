import { FC, forwardRef } from 'react';
import { Product } from 'src/types/products';
import { Button } from '../ui/button';
import { useCart } from '@/lib/cart/CartContext'; 
import './ProductsCard.css';
import { useNavigate } from 'react-router-dom';
interface ProductCartProps extends React.HTMLAttributes<HTMLDivElement> {
  product: Product;
}

const ProductCart: FC<ProductCartProps> = forwardRef<HTMLDivElement, ProductCartProps>(
  
  ({ product, ...props }, ref) => {
    const { addToCart } = useCart();
    const navigate = useNavigate();

    return (
      <div
        className="product-card"
        ref={ref}
        {...props}
      >
        <img onClick={() => navigate(`/products/${product.id}`)} src={product.image} alt={product.title} className="product-card__image" />
        <h2 className="product-card__title">{product.title}</h2>
        <p className="product-card__category">Category: {product.category}</p>
        <p className="product-card__rating">Rating: {product.rating.rate} ({product.rating.count} reviews)</p>

        <Button onClick={() => addToCart(product)}>Add to Cart</Button>
      </div>
    );
  }
);

export default ProductCart;
