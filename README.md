# BrownieFudgeSundae

# index
HTML
CSS
Base styles
Helper styles
Grid systems





## HTML ( Hypertext Markup Language )
HTML is a language that allows you to express content in an explicit, structured and semantic manner.
We won’t be focusing on the “semantic” aspect so much.

Here is an example snippet,

```
<section class=”testimonial”>
	<h2>
		Mario Windsor
	</h2>
	<p class=”quote”>
		It’s a very good!
	</p>
</section>
```

[ insert image here ]

### tags
HTML has what are called “tags” or “elements” that you enclose content in.

#### syntax
```
<tag>
	content
</tag>
```

( OR )

```
<tag>content</tag>
```

Add indentation/spacing to add legibility.


#### types
Here, we’ll lay down some of the most commonly used ones that should suffice for our purposes.

##### generic
`div, span`

##### sectioning
`section`

##### headings
`h1, h2, h3, h4, h5, h6`

##### paragraphs / phrases
p

##### lists
ol, ul, li


#### attributes
Tags can be further annotated with “attributes” that allow you to,
modify the appearance of an element
add/modify an element’s behaviour
define custom labels
why would we need custom labels for elements you ask? So that they can be leveraged within CSS and JavaScript ( more on this later ).

You add attributes to an element’s opening tag. Like this,
```
<h1 id=”a-unique-word” class=”primary neutral green”>
	The Long Boring Documentation
</h1>
```

Following are some commonly used attributes,
id
an element can have only one of these
class
an element can have multiple class names, separated by spaces; but that doesn’t mean you do this,
```
<p class=”x y” class=”z”>blah blah</p>
```
here, only the second instance of the class attribute will be considered; hence the classes that the element belongs to is just “z”, and **not** “x” and “y”





# Base Styles
By default, browsers define a certain a certain and look and feel for all HTML elements.
Some of these appearances are consistent across all browsers and some aren’t

For example, a “button” element looks a certain way in Firefox, and another way in Chrome.
Likewise, `ul` elements in all browsers have an implicit padding added on their left. This is consistent, yes. But in most cases, it is unwanted.

In virtually every case, our designs do not build upon these default styles of elements. We almost always define a custom look and feel.

So, the first thing we do at the start of every project is to wipe the board clean. Essentially, we override the styles of all elements to a neutral “base” look. From here, we start adding our own styles.

There are a couple of files in the starter kit that effectively perform this “clean slate” function. For now, we won’t worry about their inner workings. Rest assured, they give a **consistent** foundation that you can start working off off.

Here’s a sample,

```
ul {
	padding-left: 0;
}
button {
	background-color: transparent;
}
```




# helper classes
More than often, we find ourselves defining the same (set of) rules for elements over and over again.
So in order to reduce the bloat in CSS code, we factored out these common rules and encapsulated them behind class names.
Adding any of these class names to an element gives it those styles.

## alignment
These can be used to align text ( and even non-textual elements (in certain instances) ) horizontally,

text-left
text-right
text-center
text-justify

Pretty self-explanatory these ^.

These yank an element from its default layout and shoves it to top left/right corner of its parent, in front of it.

float-left
float-right

If the parent element “collapses” because of this, you can add this class to the parent,

clearfix


## font
text-lowercase
text-uppercase

Pretty self-explanatory these ^.

## visibility
hidden
removes an element from the layout it and hides it
It makes it as if the element does not even exist in the markup

visuallyhidden
Removes an element from the layout and hides it.
The following element will take/occupy its place/space.
This differs from the hidden class in that the element is still accessible to screen readers.
[ need to give an example ]

invisible
Simply hides an element but does not remove it from the layout. You would do this for multiple reasons. Say, if you want to animate an element from being invisible to being visible.

hide-for-mobile
Hide an element only on the mobile version of the page

show-for-mobile
Show an element only on the mobile version of the page




And now a small detour.
One way HTML elements can be broadly categorized is by the horizontal space they occupy. This aspect is governed by the “display” property of an element ( this is a CSS thing and is not related to HTML attributes ).


### block-level
These occupy an entire horizontal “row” on a page.
No element that either precedes or follows it in the markup can share space with it, even if there is vacant space.

examples
div, h1, p, section

### inline-level
These elements don’t demand their own horizontal space. Elements that follow them in the markup can sit inline with them (assuming the following elements aren’t block-level)

examples
span, a


The following classes change the “display” behaviour of elements and also influences their relative vertical alignment.

block
Makes an element block-level
inline
Makes an element inline-level
inline-top
Makes an element inline-level, and vertically aligns it to the top of the line
inline-middle
Makes an element inline-level, and vertically aligns the middle of the element with the baseline plus half the x-height of its parent element
inline-bottom
Makes an element inline-level, and vertically aligns the bottom of the element with the bottom of the line


## interaction
These control whether an element can be interacted/responsive with on clicking/tapping it.
For example, clicking on an text-box brings it to focus and allows you to type in text, say, your password for example.
These classes determine if the text-box will respond to being clicked in the first place.

no-pointer
Makes an element not respond to clicks/taps. Additionally, it will “forward” the click to the underlying element. For example, if you have a button and in front of it you have a input text-box. Now, if you add this class to the text-box and then click on it, the button behind it will depress and text-box will be completely unresponsive.

pointer
Restores an element’s default behaviour on clicking/tapping it


## cursor
cursor-pointer
Not to be confused with the “pointer” classes above. This simply makes your cursor look like the a white hand with pointing index finger. You would use this when you want to indicate to a user that this element is clickable when they hover over them. Only the button and a elements (to mention a few) have this property intrinsically.

[ image ]


## space, layout
no-wrap
Prevents text from wrapping onto subsequent lines

[ image of text in wrapped and un-wrapped version ]

no-overflow
I’ll tell you about this later.

no-whitespace
For when there is some space between elements despite not defining any space between them
You would add this to the parent of the elements that have the space between them





# grid systems
Depending on the layout that needs to be laid out, we have different grid systems that you can use.

2-column
12-column (fluid)
12-column (adaptive)

A “fluid” layout is one where the elements “respond” continuously/constantly when the browser window is re-sized, i.e. on every pixel wider, narrower, taller or shorter that it gets.

[ image ]

A “adaptive” layout is one where the elements “respond” when the browser window is re-sized to specific dimensions, and **not** on every pixel wider, narrower, taller or shorter that it gets.
[ image ]


## 2-column (adaptive)
Here is an example,

```
<div class="container">

	<section class="contain-one section-header">

		<div>this row has one column</div>

	</section>

	<section class="contain-two section-intro">

		<div class="one-of-two">
			<p>this is the first column</p>
			<p>There is a new kid on the block, and her name is “I’ve never designed with a table in my career.” To her, our old ways often seem strange and confining, and it is within this generation that we will most likely see more departures from what design conventions have emerged in the past decade.</p>
		</div>

		<div class="two-of-two">
			<p>this is the second column</p>
		</div>

	</section>

</div>
```

If a row contains only one column, enclose column markup within a div or section having a class of contain-one

If a row contains two columns, enclose the markup of both columns within a div or section having a class of contain-two
In the case where you have two columns, the first column should have a class of one-of-two, and the second one, two-of-two.

Here is the summary of all the classes used for building 2-column grids,
contain-one
contain-two
one-of-two
two-of-two

Notice the div with the class container. You always enclose your grid/layout markup in one of these.


## 12-column (fluid)
Here is an example,

```
<div class="container">

	<div class="row">
		<div class="columns three"></div>
		<div class="columns four"></div>
		<div class="columns five"></div>
	</div>

	<div class="row">
		<div class="columns five offset-by-four"></div>
	</div>

	<div class="row">
		<div class="columns six offset-by-one"></div>
		<div class="columns two offset-by-two"></div>
	</div>

</div>
```

Here’s what it looks like, (we’ve omitted the CSS used to style this)




Each cell should have a class of column. You add another class – either one, two, …, or twelve, depending on the number of columns it needs to span.

If you need to offset a cell, add a offset-by-<number> class where <number> can be any value from one to eleven.


## 12-column (adaptive)
Here is an example,

```
<div class="container">

	<div class="row">
		<div class="columns small-12 medium-3"></div>
		<div class="columns small-12 medium-4"></div>
		<div class="columns small-12 medium-5"></div>
	</div>

	<div class="row">
		<div class="columns small-12 medium-5 large-offset-4"></div>
	</div>

	<div class="row">
		<div class="columns small-12 medium-6 large-offset-1"></div>
		<div class="columns small-12 medium-2 large-offset-2"></div>
	</div>

</div>
```

Here’s what it looks like, (we’ve omitted the CSS used to style this)



Similar to the previous 12-column grid (fluid) grid system, each cell should have a class of column.

In this system however, you have more control over the width of a cell. You can make cell span 12 columns on mobile screen, 4 columns on tablet, and 3 columns on desktop/laptops.
Instead of having class names with just the numbers, here, they are prefixed with either small-, medium- or large-. Also, the numbers are not spelled out in english.
Like so,
small-12
medium-4
large-3

Similarly, the classes to offset cells are like so,
small-offset-1
medium-offset-2
large-offset-6

## containers
If you noticed, all our grid/layout markup was always enclosed within a div with a class of container.

This constrains the maximum width of the layout so that the grid doesn’t just keep stretching forever.


