import { LogInValidation } from "@/lib/Validation";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { Button } from "@/components/ui/button";
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Link, useNavigate } from "react-router-dom";
import { useAuth } from "@/lib/appwrite/AuthContext";
import { useToast } from "@/hooks/use-toast";
import { useState } from "react";
import { ToastAction } from "@radix-ui/react-toast";

const LogIn = () => {
  const form = useForm<z.infer<typeof LogInValidation>>({
    resolver: zodResolver(LogInValidation),
    defaultValues: {
      email: '',
      password: '',
    },
  });

  const { toast } = useToast();
  const navigate = useNavigate();

  const { loginUser, checkUserStatus, loading: isUserLoading } = useAuth(); 
  const [isLoading, setIsLoading] = useState(false); 

  const handleSignIn = async (values: z.infer<typeof LogInValidation>) => {
    setIsLoading(true); 
    const session = await loginUser(values);
    setIsLoading(false);

    if (!session) {
      toast({
        title: "Login failed. Please try again.",
        variant: "destructive",
        action: <ToastAction altText="Try again">Try again</ToastAction>,
      });
      return;
    }

    const isLoggedIn = await checkUserStatus();

    if (isLoggedIn) {
      form.reset();
      navigate("/");
    } else {
      toast({
        title: "Login failed. Please try again.",
        variant: "destructive",
        action: <ToastAction altText="Try again">Try again</ToastAction>,
      });
    }
  };



  return (
    <Form {...form}>
      <form
        onSubmit={form.handleSubmit(handleSignIn)}
        className="space-y-8 bg-slate-400/40 backdrop-blur-lg fixed px-28 py-12 rounded-md z-50 text-zinc-100"
      >
        <FormField
          control={form.control}
          name="email"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Email: </FormLabel>
              <FormControl>
                <Input placeholder="enter email" className="shad-input" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />

        <FormField
          control={form.control}
          name="password"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Password: </FormLabel>
              <FormControl>
                <Input placeholder="enter password" className="shad-input" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />

        <div>
          <Link to="/sign-up" className="text-blue-700 drop-shadow">create an account?</Link>
        </div>

        <Button
          type="submit"
          className="bg-blue-500 text-white px-4 py-2 rounded-md w-full hover:bg-blue-600"
          disabled={isLoading || isUserLoading}
        >
          {isLoading ? "Logging in..." : "Log in"} 
        </Button>

      </form>
    </Form>
  );
};

export default LogIn;
