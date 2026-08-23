<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:spaces-teaser */
class __TwigTemplate_befc0d0d704fe4fceef5c18616532718 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--spaces-teaser"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:spaces-teaser"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:spaces-teaser"));
        $context["icon_by_key"] = ["desk" => "wifi", "meeting" => "users", "studio" => null];
        // line 2
        $context["tag_by_access"] = ["journalist" => "Accredited access", "company" => "CFC Members only", "both" => null];
        // line 3
        yield "
<section class=\"bg-[#FCFCFB] py-20\">
  <div class=\"max-w-[1440px] mx-auto px-12\">
    <div class=\"flex items-end justify-between mb-14\">
      <div>
        <div class=\"flex items-center gap-3 mb-3\">
          <div class=\"w-5 h-[2px] bg-[#9F5434]\"></div>
          <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#0F6E56] font-semibold\">Spaces</div>
        </div>
        <h2 class=\"text-neutral-900 tracking-tight max-w-[680px]\" style=\"font-size: 56px; font-weight: 600; line-height: 1.05; letter-spacing: -0.025em;\">
          Three spaces. <span class=\"text-neutral-400\">One hub.</span>
        </h2>
      </div>
    </div>

    <div class=\"grid grid-cols-3 gap-6\">
      ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["spaces"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
            // line 20
            yield "        ";
            $context["tag"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["tag_by_access"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["s"], "access_rule", [], "any", false, false, true, 20), [], "array", true, true, true, 20) &&  !(null === (($_v0 = ($context["tag_by_access"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "access_rule", [], "any", false, false, true, 20)) instanceof \Stringable ? (string) $_v1 : $_v1)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["tag_by_access"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["s"], "access_rule", [], "any", false, false, true, 20), [], "array", false, false, true, 20))))) ? ((($_v2 = ($context["tag_by_access"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2[(($_v3 = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "access_rule", [], "any", false, false, true, 20)) instanceof \Stringable ? (string) $_v3 : $_v3)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["tag_by_access"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["s"], "access_rule", [], "any", false, false, true, 20), [], "array", false, false, true, 20))) : (null));
            // line 21
            yield "        ";
            $context["icon"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["icon_by_key"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 21), [], "array", true, true, true, 21) &&  !(null === (($_v4 = ($context["icon_by_key"] ?? null)) && is_array($_v4) || $_v4 instanceof ArrayAccess && in_array($_v4::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v4[(($_v5 = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 21)) instanceof \Stringable ? (string) $_v5 : $_v5)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["icon_by_key"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 21), [], "array", false, false, true, 21))))) ? ((($_v6 = ($context["icon_by_key"] ?? null)) && is_array($_v6) || $_v6 instanceof ArrayAccess && in_array($_v6::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v6[(($_v7 = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 21)) instanceof \Stringable ? (string) $_v7 : $_v7)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["icon_by_key"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 21), [], "array", false, false, true, 21))) : (null));
            // line 22
            yield "        <article class=\"group relative rounded-2xl overflow-hidden border transition-all hover:-translate-y-1 ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "highlight", [], "any", false, false, true, 22)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("border-[#0F6E56] bg-[#0F6E56] text-white shadow-[0_30px_80px_-30px_rgba(15,110,86,0.5)]") : ("border-neutral-200 bg-white hover:border-[#9F5434]/30 hover:shadow-[0_20px_50px_-20px_rgba(159,84,52,0.1)]")));
            yield "\">
          <a href=\"";
            // line 23
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["spaces_url"] ?? null), "html", null, true);
            yield "#space-";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 23), "html", null, true);
            yield "\" class=\"relative h-56 overflow-hidden block bg-neutral-100\">
            ";
            // line 24
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "image_url", [], "any", false, false, true, 24)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 25
                yield "              <img src=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "image_url", [], "any", false, false, true, 25), "html", null, true);
                yield "\" alt=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "title", [], "any", false, false, true, 25), "html", null, true);
                yield "\" class=\"w-full h-full object-cover group-hover:scale-105 transition-transform duration-700\" />
            ";
            }
            // line 27
            yield "            ";
            if ((($tmp = ($context["tag"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 28
                yield "              ";
                yield from $this->load("cfc_media_hub:spaces-teaser", 28, 1)->unwrap()->yield(CoreExtension::merge($context, ["variant" => "light", "attributes" => $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute(["class" => ["absolute", "top-4", "left-4"]])]));
                // line 31
                yield "            ";
            }
            // line 32
            yield "            ";
            if ((($tmp = ($context["icon"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 33
                yield "              <div class=\"absolute top-4 right-4 w-9 h-9 rounded-full flex items-center justify-center backdrop-blur ";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "highlight", [], "any", false, false, true, 33)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("bg-white text-[#0F6E56]") : ("bg-white/85 text-neutral-700")));
                yield "\">
                ";
                // line 34
                yield from $this->load("cfc_media_hub:icon", 34)->unwrap()->yield(CoreExtension::toArray(["name" => ($context["icon"] ?? null), "size" => "w-4 h-4"]));
                // line 35
                yield "              </div>
            ";
            }
            // line 37
            yield "          </a>

          <div class=\"p-7\">
            <h3 class=\"tracking-tight mb-3\" style=\"font-size: 26px; font-weight: 600; letter-spacing: -0.02em;\">
              <a href=\"";
            // line 41
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["spaces_url"] ?? null), "html", null, true);
            yield "#space-";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 41), "html", null, true);
            yield "\">";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "title", [], "any", false, false, true, 41), "html", null, true);
            yield "</a>
            </h3>
            <p class=\"leading-relaxed mb-6 text-[14px] ";
            // line 43
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "highlight", [], "any", false, false, true, 43)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("text-white/85") : ("text-neutral-600")));
            yield "\">";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "summary", [], "any", false, false, true, 43), "html", null, true);
            yield "</p>

            <ul class=\"space-y-2 mb-7\">
              ";
            // line 46
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["s"], "features", [], "any", false, false, true, 46));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 47
                yield "                <li class=\"flex items-center gap-2 text-[13px] ";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "highlight", [], "any", false, false, true, 47)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("text-white/90") : ("text-neutral-700")));
                yield "\">
                  ";
                // line 48
                yield from $this->load("cfc_media_hub:icon", 48)->unwrap()->yield(CoreExtension::toArray(["name" => "check", "size" => ("w-3.5 h-3.5 " . (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "highlight", [], "any", false, false, true, 48)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("text-[#CDEDE3]") : ("text-[#9F5434]")))]));
                // line 49
                yield "                  ";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["f"], "html", null, true);
                yield "
                </li>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['f'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 52
            yield "            </ul>

            <a href=\"";
            // line 54
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["booking_base_url"] ?? null), "html", null, true);
            yield "?space=";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "id", [], "any", false, false, true, 54), "html", null, true);
            yield "\" class=\"w-full py-3.5 rounded-xl flex items-center justify-center gap-2 transition-colors font-semibold text-[13px] ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["s"], "highlight", [], "any", false, false, true, 54)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("bg-white text-[#9F5434] hover:bg-[#9F5434]/10") : ("bg-[#9F5434] text-white hover:bg-[#8A4A2E]")));
            yield "\">
              ";
            // line 55
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "cta_label", [], "any", false, false, true, 55), "html", null, true);
            yield "
              ";
            // line 56
            yield from $this->load("cfc_media_hub:icon", 56)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-up-right", "size" => "w-4 h-4"]));
            // line 57
            yield "            </a>
          </div>
        </article>
      ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['s'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 61
        yield "    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["spaces", "spaces_url", "booking_base_url"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:spaces-teaser";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  217 => 61,  199 => 57,  197 => 56,  193 => 55,  185 => 54,  181 => 52,  170 => 49,  168 => 48,  163 => 47,  159 => 46,  151 => 43,  142 => 41,  136 => 37,  132 => 35,  130 => 34,  125 => 33,  122 => 32,  119 => 31,  116 => 28,  113 => 27,  105 => 25,  103 => 24,  97 => 23,  92 => 22,  89 => 21,  86 => 20,  69 => 19,  51 => 3,  49 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:spaces-teaser", "themes/custom/cfc_media_hub/components/spaces-teaser/spaces-teaser.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 1, "for" => 19, "if" => 24, "embed" => 28, "include" => 34];
        static $filters = ["escape" => 23];
        static $functions = ["create_attribute" => 28];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "set", 1 => "for", 2 => "if", 3 => "embed", 4 => "include"],
                [0 => "escape"],
                [0 => "create_attribute"],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}


/* cfc_media_hub:spaces-teaser */
class __TwigTemplate_befc0d0d704fe4fceef5c18616532718___1 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'label' => [$this, 'block_label'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 28
        return "cfc_media_hub:badge";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--spaces-teaser"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:spaces-teaser"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:spaces-teaser"));
        // line 28
        $this->parent = $this->load("cfc_media_hub:badge", 28);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["tag"]);    }

    // line 29
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_label(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["tag"] ?? null), "html", null, true);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:spaces-teaser";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  337 => 29,  331 => 28,  327 => 1,  320 => 28,  217 => 61,  199 => 57,  197 => 56,  193 => 55,  185 => 54,  181 => 52,  170 => 49,  168 => 48,  163 => 47,  159 => 46,  151 => 43,  142 => 41,  136 => 37,  132 => 35,  130 => 34,  125 => 33,  122 => 32,  119 => 31,  116 => 28,  113 => 27,  105 => 25,  103 => 24,  97 => 23,  92 => 22,  89 => 21,  86 => 20,  69 => 19,  51 => 3,  49 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:spaces-teaser", "themes/custom/cfc_media_hub/components/spaces-teaser/spaces-teaser.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["extends" => 28];
        static $filters = ["escape" => 29];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "extends"],
                [0 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
