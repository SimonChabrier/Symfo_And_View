# Skeleton personnalisé.

Use it to start a project with a skeleton project.

## Available dependencies

- Debug Bar
- Doctrine
- Maker Bundle
- Doctrine Fixture
- Php Faker
- Stof Extension Bundle
- Security Bundle
- Validator
- Verify Email Bundle
- Form Bundle
- Mailer
- Assets
- Twig Bundle
- Nelmio Cors Bundle
- Symfony Serializer Pack
- Symfony Webpack Encore Bundle + eslint
- Vuejs 3 + vue-loader 17
- Axios

## Available feature

- Basic HomeController
- Basic home template
- Basic routes and redirects after login logout register
- Full user register and login
- AutoLogin after new user registration
- Remember Me Token
- Verification email send + display success message after user click on mail verification link.
- CreatedAt UpdatedAt generate in User Entity by Stof Extensio Bundle
- Slug generate in User Entity by Stof Extensio Bundle
- Public directory content: pictures / css + reset.css -> scss ready (need Sass Compiler extension) / fonts -> Poppins / js / Favicon
- <head> ready to personalize

## How to use

- start dev server

```bash
symfony serve
```

- start webpack server

```bash
npm run dev-server
```

- start webpack watch

```bash
npm run watch
```

- start webpack build production

```bash
npm run build
```

- restart webpack server
    
```bash
npm run dev-server
```

- https://symfony.com/doc/5.4/frontend/encore/installation.html pour ajouter encore
- https://symfony.com/doc/5.4/frontend/encore/vuejs.html pour ajouter vuejs


 J'installe et configure web pack.
 
```bash
composer require symfony/webpack-encore-bundle
```

J'ajoute le vueLoader au fichier de config `webpack.config.js` puis je relance le serveur webpack et ensuite intaller :

```bash
 npm install vue@^3 vue-loader@^17 vue-template-compiler --save-dev
```

Il signale cette installation au redemarrage du serveur webpack quand il voit que le vueLoader est déclaré dans `webpack.config.js`  mais ne donne pas les bonnes versions pour vue 3 
