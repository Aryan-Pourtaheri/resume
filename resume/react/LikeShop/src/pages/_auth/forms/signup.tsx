  import { SignUpValidation } from "@/lib/Validation"
  import { zodResolver } from "@hookform/resolvers/zod"
  import { useForm } from "react-hook-form"
  import { z } from "zod"
  import { Button } from "@/components/ui/button"
  import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
  } from "@/components/ui/form"
  import { Input } from "@/components/ui/input"
  import { Link, Navigate, useNavigate } from "react-router-dom"
  import { useAuth } from "@/lib/appwrite/AuthContext"


  const Signup = () => {
    const { registerUser , user} = useAuth()

    const navigate = useNavigate();

    const form = useForm<z.infer<typeof SignUpValidation>>({
      resolver: zodResolver(SignUpValidation),
      defaultValues: {
        name:'',
        username: '',
        email: '', 
        password: '',
      },
    })

    

    async function onSubmit(values: z.infer<typeof SignUpValidation>) {
      try {
        const newUser = await registerUser(values);
        if (newUser && newUser.newAccount) {
          navigate('/');
        } else {
          console.log("User registration failed");
        }
      } catch (error) {
        console.log("Error during registration:", error);
      }
    }

    return (
      <Form {...form}>
        <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8 bg-slate-400/40 backdrop-blur-lg fixed px-28 py-12 rounded-md z-50 text-zinc-100">
          <FormField
            control={form.control}
            name="name"
            render={({ field }) => (
              <FormItem>
                <FormLabel>Name: </FormLabel>
                <FormControl>
                  <Input placeholder="enter name" className="shad-input" {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            control={form.control}
            name="username"
            render={({ field }) => (
              <FormItem>
                <FormLabel>Username: </FormLabel>
                <FormControl>
                  <Input placeholder="enter username" className="shad-input" {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />
        
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
                  <Input placeholder="enter Password" className="shad-input" {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />

          <div>
            <Link to="/log-in" className="text-blue-700 drop-shadow">already have an account?</Link>
          </div>

          <Button type="submit" className="bg-blue-500 text-white px-4 py-2 rounded-md w-full hover:bg-blue-600">Sign up</Button>
        </form>
      </Form>
    )
  }

  export default Signup
