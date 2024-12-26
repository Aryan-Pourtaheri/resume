import { Account, Client, Databases, Storage, Avatars } from 'appwrite';

const client = new Client();

export const configs = {
  projectId: import.meta.env.VITE_APPWRITE_PEOJECT_ID,
  url: import.meta.env.VITE_APPWRITE_URL,
  databases: import.meta.env.VITE_APPWRITE_DATABASE,
  collections: import.meta.env.VITE_APPWRITE_COLLECTIONS,
  count: import.meta.env.VITE_APPWRITE_COLLECTIONS_PRODUCTS_COUNT
}

client
  .setEndpoint(configs.url)
  .setProject(configs.projectId);


export const account = new Account(client);
export const databases = new Databases(client);
export const storage = new Storage(client);
export const avatars = new Avatars(client);

export default client;