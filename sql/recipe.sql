CREATE DATABASE IF NOT EXISTS recipe;
USE recipe;

CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type ENUM('meal', 'dessert', 'drinks') NOT NULL,
    ingredients TEXT NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL
);

INSERT INTO recipes (name, type, ingredients, description, image) VALUES
(
    'Good Frickin\' Paprika Chicken',
    'meal',
    '6 tablespoons plain yogurt\n3 cloves garlic, crushed\n3 tablespoons ground paprika\n2 tablespoons olive oil\n1 tablespoon hot chile paste (such as sambal oelek)\n1 pinch cayenne pepper\n1 (5 pound) whole chicken, cut into 8 pieces\nsalt\n¼ cup olive oil\n2 tablespoons sherry vinegar\n1 tablespoon ketchup\n⅛ teaspoon hot chile paste (such as sambal oelek)\n1 pinch paprika\nsalt and pepper to taste',
    '1. Whisk together yogurt, garlic, 3 tablespoons paprika, 2 tablespoons olive oil, 1 tablespoon hot chile paste, and cayenne pepper in a large bowl.\n2. Mix in chicken pieces and toss to evenly coat. Cover the bowl with plastic wrap and marinate in the refrigerator for 3 hours.\n3. Preheat an outdoor grill for medium-high heat, and lightly oil the grate.\n4. Remove chicken from the bag and transfer to a plate or baking sheet lined with paper towels. Pat chicken pieces dry with more paper towels. Season with salt.\n5. Combine 1/4 cup olive oil, sherry vinegar, ketchup, 1/8 teaspoon hot chile paste, pinch paprika, salt, and pepper in a small bowl. Set aside.\n6. Grill chicken, skin-side down, on the preheated grill for 4 minutes with grill lid closed.\n7. Turn chicken and grill with lid closed until well-browned and meat is no longer pink in the center, about 6 minutes. An instant-read thermometer inserted into the thickest part of the thigh should read 180 degrees F (82 degrees C).\n8. Spoon sherry vinegar mixture over cooked chicken and serve.',
    'image/good_frickin_paprika_chicken.jpg'
);

INSERT INTO recipes (name, type, ingredients, description, image) VALUES
(
    'Tiramisu Toffee Dessert',
    'dessert',
    '1 (10.75 ounce) package frozen prepared pound cake, thawed and cut into 9 slices\n¾ cup strong brewed coffee\n1 (8 ounce) package cream cheese\n1 cup white sugar\n½ cup chocolate syrup\n2 cups heavy whipping cream\n2 (1.4 ounce) bars chocolate covered English toffee, chopped',
    '1. Arrange cake slices on bottom of a rectangular 11x7 inch baking dish, cutting cake slices if necessary to fit the bottom of the dish. Drizzle coffee over cake.\n2. Beat cream cheese, sugar, and chocolate syrup, in a large bowl with an electric mixer on medium speed until smooth. Add heavy cream; beat on medium speed until light and fluffy. Spread over cake. Sprinkle with chocolate-covered toffee candy.\n3. Cover and refrigerate for at least 1 hour, but no longer than 24 hours, to set dessert and blend flavors.',
    'image/tiramisu_toffee_dessert.jpg'
);

INSERT INTO recipes (name, type, ingredients, description, image) VALUES
(
    'Moscow Mule Cocktail',
    'drinks',
    '1 ½ fluid ounces vodka\n½ fluid ounce lime juice\nice cubes\n½ cup ginger beer\n1 lime wedge for garnish',
    '1. Pour vodka and lime juice into a mug; add ice cubes and ginger beer. Stir to combine.\n2. Drop a lime wedge into the mug for garnish.',
    'image/moscow_mule_cocktail.jpg'
);
