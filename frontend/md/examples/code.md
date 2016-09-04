---
title: "examples / code blocks"
---

# Code Blocks

There are two types of code blocks. One is the basic `<pre>` Element in combination
with the `<code>` tag. The good thing about this one is that you can create it by just
indenting all relevant lines with 4 spaces.

     Which will look like this
     
The other, more elaborate, code block is wrapped in a so called "fenced" block: <code>```</code>

The interesting part is that you can add a language identifier right behind it which
then adds a CSS class ot the block for further formatting (maybe with a javascript syntax highlighter)

Begin with: <code>```js</code>

```js
$(document).ready(function(){
  console.log('hello world.');
});
```

And close with <code>```</code>

## Which languages are supported?

Currently there is no fixed system in place that restricts the value following *the fence* delimiter. 
Basically anything you write afterwards is added to the class-name. Use Javascript or CSS for styling.

