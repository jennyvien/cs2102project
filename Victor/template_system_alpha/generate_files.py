#!/usr/bin/env python3
import os
from jinja2 import Environment, FileSystemLoader

debug = 0	

# fix the output path
output = "output"
if not os.path.exists(output):
	os.makedirs(output)

#initialize the directory (now points to templates folder)
env = Environment(loader = FileSystemLoader('templates'))

targets = os.listdir('templates')
filetypes = {".html", ".php"}
for i in targets:	
	if os.path.splitext(i)[1] in filetypes:
		print("writing: ", i)
		template = env.get_template(i)
		temp = template.render()
		with open(os.path.join(output, i), 'w') as f:
			if not debug:
				f.write(temp)
			else:
				for i in temp:
					print(i)
					f.write(i)
