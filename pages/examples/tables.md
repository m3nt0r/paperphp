---
title: "examples / tables"
---

# Tables

The syntax for such a table basically emulates the rendered version:

    | Table heading        | For The             | Masses  |
    | -------------------- |---------------------|---------|
    | Example Row 1        | Something here      |   4.000 |

Here is how a table with default styling looks like

| Table heading        | For The             | Masses  |
| -------------------- |---------------------|---------|
| Example Row 1        | Something here      |   4.000 |
| Row Number 2         | Extra Mass          |     340 |
| Example 3            | Hello World         |  12.859 |
    
***

## Alignment

You can change the alignment of the data by placing a colon at the beginning
and/or end of the table-header line.

Example for _Masses_, notice the `:` at the end?

    | Table heading        | For The             | Masses  |
    | -------------------- |---------------------|--------:|
    | Example Row 1        | Something here      |   4.000 |
    
This will cause all rows in that column to be right aligned.

| Table heading        | For The             | Masses  |
| -------------------- |---------------------|--------:|
| Example Row 1        | Something here      |   4.000 |
| Row Number 2         | Extra Mass          |     340 |
| Example 3            | Hello World         |  12.859 |

***

## Center Alignment

For centering you would just add a colon on both sides of the column:

    | Table heading        | For The             | Masses  |
    | -------------------- |---------------------|:-------:|
    | Example Row 1        | Something here      |   4.000 |
    
Which then looks like this
   
| Table heading        | For The             | Masses  |
| -------------------- |---------------------|:-------:|
| Example Row 1        | Something here      |   4.000 |
| Row Number 2         | Extra Mass          |     340 |
| Example 3            | Hello World         |  12.859 |

***