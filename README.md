The command will update secrets on Vapor.

To work, a secrets folder needs to be created at the root of the application along with a subfolder for each environment. Each secret is stored in its own file, ie. SECRET_NAME.txt.
> In order not to commit secrets, add the path of the secret folder to your gitignore file

Example Folder Layout:
![image](https://user-images.githubusercontent.com/164155/161297647-40fe542b-ade4-47e5-8182-10feb119e4de.png)

### To Run Command
```
vapor secret:update <vapor-environment-name>
```
