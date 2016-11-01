#include <stdlib.h>
#include <locale.h>
#include <stdio.h>
#include <string.h>

int main()
{
    setlocale(LC_ALL, "en_US.utf8"); // or any other utf8 locale
    wchar_t c = L'\x8C'; // or = L'\xc5';
    char mb[MB_CUR_MAX + 1];
    int len = wctomb(mb, c);
    mb[len] = '\0';
    printf("UTF-8 char: %s\n", mb);


    char *p = "0x8C";
	unsigned int intVal;
	sscanf(p, "%x", &intVal);
	printf("value x: %x - %d", intVal, intVal);

	printf("\n");

	char *hex_str = "86D6D6C28BF3EAF060F37E89D6F07EC2C2F0EAC289D6D28B7E7E8CF08CC2C2EA92EA8CC286F06CD6D2926CD660F3D6EA8C866C86898BD66CF0C2D2897E8BC2F0";
	char * res;
	// int r[64];
   
	int s = 0;
	int v2;
	int v1;
	for(int j = 0; j < 128; j = j + 2) {

        sprintf(res, "%c%c", hex_str[j], hex_str[j+1] );
    	// printf("%s ", res);
   
		sscanf(res, "%x", &intVal);
		// printf(" %x - %d ", intVal, intVal);

		v2  = intVal;
	 	
		    ////////
		    if ( v2 > 193 )
		    {
		      if ( v2 > 233 )
		      {
		        switch ( v2 )
		        {
		          case 234:
		            v1 = 100;
		            break;
		          case 240:
		            v1 = 50;
		            break;
		          case 243:
		            v1 = 57;
		            break;
		        }
		      }
		      else
		      {
		        switch ( v2 )
		        {
		          case 194:
		            v1 = 102;
		            break;
		          case 210:
		            v1 = 53;
		            break;
		          case 214:
		            v1 = 98;
		            break;
		        }
		      }
		    }
		    else if ( v2 > 133 )
		    {
		      switch ( v2 )
		      {
		        case 137:
		          v1 = 52;
		          break;
		        case 139:
		          v1 = 49;
		          break;
		        case 140:
		          v1 = 54;
		          break;
		        case 146:
		          v1 = 97;
		          break;
		        case 138:
		        case 141:
		        case 142:
		        case 143:
		        case 144:
		        case 145:
		          break;
		        default:
		          if ( v2 == 134 )
		            v1 = 101;
		          break;
		      }
		    }
		    else
		    {
		      switch ( v2 )
		      {
		        case 96:
		          v1 = 51;
		          break;
		        case 108:
		          v1 = 55;
		          break;
		        case 126:
		          v1 = 99;
		          break;
		      }
		    }

		  // printf("-> %d", v1);
		  printf("%c", (char)v1);

		s++;
		 
    }
    // printf("%d\n", s);


}


// input hex value
// 86 D6 D6 C2 8B F3 EA F0  60 F3 7E 89 D6 F0 7E C2
// C2 F0 EA C2 89 D6 D2 8B  7E 7E 8C F0 8C C2 C2 EA
// 92 EA 8C C2 86 F0 6C D6  D2 92 6C D6 60 F3 D6 EA
// 8C 86 6C 86 89 8B D6 6C  F0 C2 D2 89 7E 8B C2 F0
// 00




// \x86
// \xD6
// \xD6
// \xC2
// \x8B
// \xF3
// \xEA
// \xF0
// `
// \xF3
// ~
// \x89
// \xD6
// \xF0
// ~
// \xC2
// \xC2
// \xF0
// \xEA
// \xC2
// \x89
// \xD6
// \xD2
// \x8B
// ~
// ~
// \x8C
// \xF0
// \x8C
// \xC2
// \xC2
// \xEA
// \x92
// \xEA
// \x8C
// \xC2
// \x86
// \xF0
// l
// \xD6
// \xD2
// \x92
// l
// \xD6
// `
// \xF3
// \xD6
// \xEA
// \x8C
// \x86
// l
// \x86
// \x89
// \x8B
// \xD6
// l
// \xF0
// \xC2
// \xD2
// \x89
// ~
// \x8B
// \xC2
// \xF0

