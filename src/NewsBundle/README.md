NewsBundle
===========

This bundle gives you an easy interface for creating and managing News

## Getting started

Before you use this bundle make sure that you have a DataObject Class named `News`
initialized in Pimcore under _Settings > DataObject > Classes_

Set three variables under _Settings > Website_

```
Type	Name
-------------------------
Text 	NewsParentId
Text 	NewsSiteSlideshow
Text 	NewsSiteStartpage
```

__NewsParentId__ is the ID of a Folder where you want the bundle to put your News objects.
__NewsSiteSlideshow__ gives the sites some special rules for the Slideshow
__NewsSiteStartpage__ gives the sites some special rules for the startpage News

### Author: M. Ali & Jimmi Elofsson <jimmi.elofsson@lexiconitkonsult.se>
