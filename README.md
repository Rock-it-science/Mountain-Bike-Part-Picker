# Mountain-Bike-Part-Picker

As of Jan 14 this project is abandoned. It was a fun project to help learn PHP, but the real PC Part Picker guys seem to be working on something much bigger and better.



Build your bike virtually to see compatibility and pricing, or just toy with the most expensive bike you can build


Please note that until I have at the very least a better working framework, I will not be publicly hosting this, so if you plan on hosting locally, make sure you have your sql databases set up correctly.

What's here:
- Select parts and add to build
- Basic compatibility framework (currently only implemented for wheel size between frame and fork)
- Dynamic total price based on part prices
- Can add new parts of any type through the createPage
- Lots of details and options for frames and forks
- Parts link to manufacturers page
- Parts show a picture

What's on its way:
- Add more details for each part (add to SQL and to <partname>.php)
  - hardtail vs full sus implemented in index table
  - Frames often come with shocks when you buy them
    - Auto add shock that comes with frame?
- Requiring fields to be filled before attempting to add parts
- More different kinds of parts
  - Replace drivetrain with individual parts (chain, cassette, derailleur, etc)
  - wheels
  - brakes
  - ... and more
- SQL version control
- More compatibility (see compatibility.js)
- Improve SQL security (DO THIS BEFORE HOSTING)
  - Password on SQL server
  - Sanitize input

What's coming later:
- Ability to filter parts by brand and intended use (xc, dh, am etc)
- Only show compatible parts on partList pages
- Dynamic part pricing with manufacturer MSRP, and retailer prices
- More photos of each part
- Front end stuff so this doesn't look like its from the 90s
