# Introduction #

Three CMS handles content in it's own unique way. You'll read more about that in this article.

# Details #

In most content management systems out there, most of the way of how to fill in content is pre-defined. Each page has a name, a description, content, etc... Some CMS's also allow you to add some specific parameters that belong to a page, for instance: a news page also want to have an author-field, or a date-field.

Three CMS handles content as induvidual pieces of information. For example: For your website you have default pages which all have the default items such as a header, a description, some content, a menutitle, etc. But at some point, you also have specific pages, such as job offerings, news, pictures, etc...

In most CMS-es you can make a news page and add some other pages as subpages of the newspage to act as newsitems. Not in Three CMS: Three CMS will see the news item as it's own induvidual piece of content, which would only need it's own induvidual fields.

The scheme below visualizes this concept:


![http://threecms.com/forum/download/file.php?id=49&.png](http://threecms.com/forum/download/file.php?id=49&.png)

# A more practical example #

## Scenario ##

Say, you've got a personal website. Most pages are content-pages with a header, some content and a nice image on top of the page. Basicly, the only 3 options a page then needs are:

  1. Header
  1. Content
  1. Top Image

## Options and Data Objects ##

In Three CMS we can create these three options. This can be done under **System > Option Types**. We can create an option called 'header' which is of the type 'text', since it only represents a single header. Next we create an option called 'content', which is of the type 'richtext', because this is the main area of our page where all the content is. Third we create an option called 'topImage' which is of the type 'image'. This allows us to directly select an image in Three CMS using the built-in image browser.

Now, when these three options are created in Three CMS, you can create a dataobject linking them together. This can be done under **System > Data Object Types**. We call this dataobject _"default page data"_. The following step is to create a template.

## Templates ##

Now, templates do basicly one important thing: They link data objects and physical template files together. Template files are located in `site/templates`. You might not see any now, because offcourse you have to create your own templates, since these will be the base HTML of your website.

Now, with our freshly created options and data object that links these options together we could create a simple template like this:

```
<html>
  <head>
    <title>My site : {$header}</title>
  </head>
  <body>
    <img src="{$topImage}" />
    <h1>{$header}</h1>
    {$content}
  </body>
</html>
```

Now, if we create pages (or actually '_content objects_', but more on that later) the parameters set in our template will be automaticly filled by whatever is filled in in the CMS.

Now, there are some other options with templates you should get yourself familiar with:

  * **Can be added to the root**: When this is enabled, this template can be used for pages that are nested (or are going to be created) on the root of the site.
  * **Type**: a Template can be a _page_ or an individual piece of _content_. We get back on this in the following chapter.
  * **Allowed child templates**: Here you can set which templates are allowed to be a child of this template. For example, a news page should only be allowed to have children with the template 'news Item', or a portfolio page for example should only have children with either the template 'picture' or 'music'.
  * **Template is available for the following ranks**: Here you can set the right management on template level. On this way you can make sure your client can only use the templates where he has the right to (so he can only place news items and not mess up your contact form template for example).

You can have multiple templates make use of the same data object so you won't have to create new data objects each time you have a new template with only minor HTML-changes.

### Page or Content? ###

As mentioned above, a template can be of the type _page_ or of the type _content_. This is one of the **key features** what distinguishes Three CMS from other CMS-es. In short:

A _page_ is physical a complete page. So the template of a page starts with `<html>` and ends with `</html>`. This is the same way how most CMS-es handle their templates.

_Content_ on the other hand is a piece of content that should be put inside a page. For example, on a news site, the template file of a news-item-template could look like this:

```
<div class="newsItem">
  <h3>{$header}</h3>
  <span class="date">{$date}</span>
  {$content}
</div>
```

Where does this piece of code get injected you wonder? Well, Three CMS scans the tree down until it finds a parent of the type _page_. It will then render that page and gives a parameter providing information on the news item to show. More examples on this matter you can find on the [Template Design and Development page](Templates.md).