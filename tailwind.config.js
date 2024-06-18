const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		 './storage/framework/views/*.php',
		 './resources/views/**/*.blade.php',
		 './resources/views/**/**/*.blade.php',
		 './resources/views/admin/settings/*.blade.php',
		 './resources/views/**/*.js',
		 './resources/views/rifa/admin/**/*.blade.php',
		 './resources/views/rifa/admin/**/*.php',
		 './resources/views/**/*.php',
		
		 './resources/views/layouts/*.php',
		 './resources/views/layouts/*.blade.php',
		 './resources/views/**/*.html',
		 './resources/views/**/*.vue',
		 './resources/views/**/**/*.blade.php',
		 './resources/views/**/**/*.php',
		 './resources/views/**/**/**/*.blade.php',
		 './resources/views/**/**/**/*.php',
		 './vendor/robsontenorio/mary/src/View/Components/**/*.php'
	],


	safelist: [
		'box-class',
		
	  ],

	plugins: [require("daisyui")],

	daisyui: {
		themes: ["light", "dark", "cupcake"], // false: only light + dark | true: all themes | array: specific themes like this ["light", "dark", "cupcake"]
		darkTheme: 'dark', // name of one of the included themes for dark mode
		base: true, // applies background color and foreground color for root element by default
		styled: true, // include daisyUI colors and design decisions for all components
		utils: true, // adds responsive and modifier utility classes
		prefix: "", // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
		logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
		themeRoot: ":root", // The element that receives theme color CSS variables
	  },
};


  