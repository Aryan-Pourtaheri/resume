import { z } from "zod"

export const SignUpValidation = z.object({
  name: z.string().min(2, {message:"name must be at least 2 characters"}),
  username: z.string().min(2 , {message:"username must be at least 2 characters"}).max(50),
  email: z.string().email(),
  password: z.string().min(8 , {message:"password must be at least 8 characters"})
})

export const LogInValidation = z.object({
  email: z.string().email(),
  password: z.string().min(8 , {message:"password must be at least 8 characters"})
})
